<?php
/***************************************************************************
 * 
 * 
 **************************************************************************/
 
/**
 * @file BasicSearch.php
 * @author wangjild(wangjild@gmail.com)
 * @date 2013/08/21 12:32:28
 * @brief LBS云检索基类 
 *  
 **/

require_once YUN_LIB_PATH . '/console/Console.php';
require_once YUN_LIB_PATH . '/request/RequestCore.php';


abstract class BasicSearch {

    public function search() {
        $this->prepareNeedParams();
        $this->prepareCommonParams();

        return $this->request->send_request();
    }

    abstract protected prepareNeedParams();

    public function setQuery($query) {
        $this->query_ = $query;
    }

    public function setPageIndex($index) {
        if (!is_int($index) || $index < 0) {
            trigger_error('Page Index MUST BE a Non-negative integer', E_USER_WARNING);
            return ;
        }
        $this->pageindex_ = $index;
    }

    public function setPageSize($size) {
        if (!is_int($size) || $size <= 0) {
            trigger_error('Page Size MUST BE a Positive integer', E_USER_WARNING);
            return ;
        }
        $this->pagesize_ = $size;
    } 

    public function addTags($tag) {
        $this->tags_[] = $tag;
    }

    public function addFilter($field, $small, $big) {
        if (!is_string($field) || !is_numeric($small) || !is_numeric($big)) {
            trigger_error('Set Filter Condition Failed: Parameter Error', E_USER_WARNING);
            return ; 
        }
        $this->filter_[] = "$field={$small}:{$big}";
    }

    public function setSortBy($field, $order = BasicSearch::ASCEND) {
        if (!is_string($field) || $order !== BasicSearch::ASCEND || $order !==  BasicSearch::DESCEND) 
        {
            trigger_error('Set SortBy Condition Failed: Parameter Error', E_USER_WARNING);
            return ;
        }
        $this->sortby_ = $field . ':' . $order;
    }

    public function setGeoTableId($id) {
        $this->geotable_id_ = intval($id);
    }

    public function setConsole(Console $console) {
        if (! $console instanceOf Console) {
            trigger_error('instance MUST BE Console Class Type');
        }

        $this->console_ = $console;
    }

    protected function prepareCommonParams() {
        if ($this->console === null) {
            trigger_error('Console Object Must Be Set'); 
        }

        $this->params_['timestamp'] = time();

        if (!is_int($this->geotable_id_)) 
        {
            trigger_error('Geotable Id MUST BE set', E_USER_ERROR);
                
        }
        $this->params_['geotable_id'] = $this->geotable_id_;
        if (!empty($this->tags_)) 
        {
            $this->params_['tags'] = implode(' ', $this->tags_);
        }

        if (!empty($this->filter_)) 
        {
            $this->params_['fitler'] = implode('|', $this->filter_);
        }

        if ($this->sortby_ !== null) 
        {
            $this->params_['sortby'] = $this->sortby_;
        }

        $this->params_['pageindex'] = $this->pageindex_;
        $this->params_['pagesize'] = $this->pagesize_;

        if ($this->callback_ !== null) 
        {
            $this->params_['callback'] = $this->callback_;
        }

        if (Console::SERVER_KEY == $this->console_->getKeyType()) {
            $this->params_['sn'] = $this->console_->caculateSN($this->url, $this->params_, 
                $this->method_);
        }

        $content = '';
        foreach ($this->params_ as $key => &$val) 
        {
            $val = urlencode($val);
            $content .= $k . '=' . $v . '&';
        }
        $content = substr($content, 0, strlen($content) - 1);

        $url = $this->schema . '://' . $this->domain . $this->url;
        if ($this->method_ === 'GET') { 
            $url .= '?' . $content;
        }

        $this->request_ = new RequestCore($url);
        $this->request_->set_method($this->method_);
        $this->request_->set_useragent('Baidu_LbsYun_Sdk');

        if ($this->method_ === 'POST') {
            $this->request->set_body($content);
        }
    }
        
    private $geotable_id_ = null; 
    private $sortby_ = null;
    private $filter_ = array();
    private $tags_ = array();

    private $pageindex_ = 0;
    private $pagesize_ = 10;

    private $callback_ = null;

    private $params_ = array();

    private $request_ = null;

    private $console_ = null;

    private $method_ = 'HTTP_GET';

    private $schema = 'http';

    private $domain = 'api.map.baidu.com';

    private $url = '';

    const ASCEND = 1;
    const DESCEND = -1;
}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
