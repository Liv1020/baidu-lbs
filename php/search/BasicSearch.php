<?php

namespace liv\lbs\search;

use liv\lbs\phplib\console\Console;
use liv\lbs\phplib\request\RequestCore;
use liv\lbs\phplib\request\ResponseCore;

/**
 * Class BasicSearch
 * @package liv\lbs\search
 */
abstract class BasicSearch
{
    /**
     * @var null
     */
    protected $geotable_id_ = null;

    /**
     * @var null
     */
    protected $query_ = null;
    /**
     * @var null
     */
    protected $sortby_ = null;
    /**
     * @var array
     */
    protected $filter_ = array();
    /**
     * @var array
     */
    protected $tags_ = array();

    /**
     * @var int
     */
    protected $pageindex_ = 0;
    /**
     * @var int
     */
    protected $pagesize_ = 10;

    /**
     * @var null
     */
    protected $callback_ = null;

    /**
     * @var array
     */
    protected $params_ = array();

    /**
     * @var RequestCore
     */
    protected $request_ = null;

    /**
     * @var Console
     */
    protected $console_ = null;

    /**
     * @var string
     */
    protected $method_ = 'GET';

    /**
     * @var string
     */
    protected $schema_ = 'http';

    /**
     * @var string
     */
    protected $domain_ = 'api.map.baidu.com';

    /**
     * @var string
     */
    protected $url_ = '';

    /**
     *
     */
    const ASCEND = 1;
    /**
     *
     */
    const DESCEND = -1;

    /**
     * @return bool|mixed
     */
    public function search()
    {
        $this->prepareNeedParams();
        $this->prepareCommonParams();

        $this->request_->send_request();

        $response = new ResponseCore($this->request_->get_response_header(),
            $this->request_->get_response_body(), $this->request_->get_response_code());
        if (!$response->isOK()) {
            return false;
        }

        return json_decode($response->body, true);
    }

    /**
     * @return mixed
     */
    abstract protected function prepareNeedParams();

    /**
     * @param $query
     */
    public function setQuery($query)
    {
        $this->query_ = $query;
    }

    /**
     * @param $index
     */
    public function setPageIndex($index)
    {
        if (!is_int($index) || $index < 0) {
            trigger_error('Page Index MUST BE a Non-negative integer', E_USER_WARNING);
            return;
        }
        $this->pageindex_ = $index;
    }

    /**
     * @param $size
     */
    public function setPageSize($size)
    {
        if (!is_int($size) || $size <= 0) {
            trigger_error('Page Size MUST BE a Positive integer', E_USER_WARNING);
            return;
        }
        $this->pagesize_ = $size;
    }

    /**
     * @param $tag
     */
    public function addTags($tag)
    {
        $this->tags_[] = $tag;
    }

    /**
     * @param $field
     * @param $small
     * @param $big
     */
    public function addFilter($field, $small, $big)
    {
        if (!is_string($field) || !is_numeric($small) || !is_numeric($big)) {
            trigger_error('Set Filter Condition Failed: Parameter Error', E_USER_WARNING);
            return;
        }
        $this->filter_[] = "$field:{$small},{$big}";
    }

    /**
     * @param $field
     * @param int $order
     */
    public function setSortBy($field, $order = BasicSearch::ASCEND)
    {
        if (!is_string($field) ||
            ($order !== BasicSearch::ASCEND && $order !== BasicSearch::DESCEND)
        ) {
            trigger_error('Set SortBy Condition Failed: Parameter Error', E_USER_WARNING);
            return;
        }
        $this->sortby_ = $field . ':' . $order;
    }

    /**
     * @param $id
     */
    public function setGeoTableId($id)
    {
        $this->geotable_id_ = intval($id);
    }

    /**
     * @param Console $console
     */
    public function setConsole(Console $console)
    {
        if (!$console instanceOf Console) {
            trigger_error('instance MUST BE Console Class Type', E_USER_ERROR);
        }

        $this->console_ = $console;
    }

    /**
     *
     */
    protected function prepareCommonParams()
    {
        if ($this->console_ === null) {
            trigger_error('Console Object Must Be Set', E_USER_ERROR);
        }

        $this->params_['ak'] = $this->console_->getAK();
        $this->params_['timestamp'] = time();

        $this->params_['q'] = $this->query_ == null ? '' : $this->query_;

        if (!is_int($this->geotable_id_)) {
            trigger_error('Geotable Id MUST BE set', E_USER_ERROR);

        }
        $this->params_['geotable_id'] = $this->geotable_id_;
        if (!empty($this->tags_)) {
            $this->params_['tags'] = implode(' ', $this->tags_);
        }

        if (!empty($this->filter_)) {
            $this->params_['filter'] = implode('|', $this->filter_);
        }

        if ($this->sortby_ !== null) {
            $this->params_['sortby'] = $this->sortby_;
        }

        $this->params_['page_index'] = $this->pageindex_;
        $this->params_['page_size'] = $this->pagesize_;

        if ($this->callback_ !== null) {
            $this->params_['callback'] = $this->callback_;
        }

        if (Console::SERVER_KEY == $this->console_->getKeyType()) {
            $this->params_['sn'] = $this->console_->caculateSN($this->url_, $this->params_,
                $this->method_);
        }

        $content = '';
        foreach ($this->params_ as $k => &$v) {
            $v = urlencode($v);
            $content .= $k . '=' . $v . '&';
        }
        $content = substr($content, 0, strlen($content) - 1);

        $url = $this->schema_ . '://' . $this->domain_ . $this->url_;
        if ($this->method_ === 'GET') {
            $url .= '?' . $content;
        }

        $this->request_ = new RequestCore($url);
        $this->request_->set_method($this->method_);
        $this->request_->set_useragent('Baidu_LbsYun_Sdk');

        if (Console::BROWSER_KEY == $this->console_->getKeyType()) {
            $this->request_->set_referer_url($this->console_->getReferer());
        }

        if ($this->method_ === 'POST') {
            $this->request_->set_body($content);
        }
    }
}