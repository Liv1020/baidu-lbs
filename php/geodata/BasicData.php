<?php

namespace liv\lbs\geodata;

use liv\lbs\phplib\console\Console;
use liv\lbs\phplib\request\RequestCore;
use liv\lbs\phplib\request\ResponseCore;


/**
 * LBS云检索基类
 * @package liv\lbs\geodata
 * @date 2013/08/21 12:32:28
 * @brief LBS云检索基类
 */
abstract class BasicData{

    /**
     * @var null
     */
    protected $geotable_id_ = null;


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
     * @var null
     */
    protected $action_ = null;

    /**
     * @var string
     */
    protected $method_ = 'POST';

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
    public function request() {
        $this->setMethod();
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
     * @param Console $console
     */
    public function setConsole(Console $console) {
        if (! $console instanceOf Console) {
            trigger_error('instance MUST BE Console Class Type', E_USER_ERROR);
        }

        $this->console_ = $console;
    }

    /**
     *
     */
    protected function prepareCommonParams() {
        if ($this->console_ === null) {
            trigger_error('Console Object Must Be Set', E_USER_ERROR); 
        }

        $this->params_['ak'] = $this->console_->getAK();
        $this->params_['timestamp'] = time();


        if ($this->callback_ !== null) 
        {
            $this->params_['callback'] = $this->callback_;
        }

        if (Console::SERVER_KEY == $this->console_->getKeyType()) {
            $this->params_['sn'] = $this->console_->caculateSN($this->url_ . $this->action_, $this->params_, 
                $this->method_);
        }

        $content = '';
        foreach ($this->params_ as $k => &$v) 
        {
            if (is_null($v)) continue;
            $v = urlencode($v);
            $content .= $k . '=' . $v . '&';
        }
        $content = substr($content, 0, strlen($content) - 1);

        $url = $this->schema_ . '://' . $this->domain_ . $this->url_ . $this->action_;
        if ($this->method_ === 'GET') { 
            $url .= '?' . $content;
        }
        
        $this->request_ = new RequestCore($url);
        $this->request_->set_method($this->method_);
        $this->request_->set_useragent('Baidu_LbsYun_Sdk');

        if (Console::BROWSER_KEY == $this->console_->getKeyType()) 
        {
            $this->request_->set_referer_url($this->console_->getReferer());
        }
        
        if ($this->method_ === 'POST') {
            $this->request_->set_body($content);
        }
    }

    /**
     *
     */
    protected function setMethod(){
        $actions = array(
            "create"    => "POST",
            "update"    => "POST",
            "delete"    => "POST",
            "detail"    => "GET",
            "list"    => "GET",

        );
        $this->method_ = isset($actions[$this->action_])?$actions[$this->action_]:"GET";
    }

    /**
     * @param $action
     */
    protected function setAction($action){
        $this->action_ = $action;
    }
}