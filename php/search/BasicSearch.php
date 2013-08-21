<?php
/***************************************************************************
 * 
 * 
 **************************************************************************/
 
require_once dirname(__FILE__) . '/../init.php'; 
 
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
        $this->prepare_request();

        $this->request->send_request();
    }

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

    protected function prepare_request() {
        
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

    const DOMAIN = 'api.map.baidu.com';

    const ASCEND = 1;
    const DESCEND = -1;
}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
