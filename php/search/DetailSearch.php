<?php
/***************************************************************************
 * BSD License 
 * http://opensource.org/licenses/bsd-license.php
 **************************************************************************/
 
/**
 * @file LocalSearch.php
 * @author wangjild(wangjild@gmail.com)
 * @date 2013/08/21 12:31:50
 * @brief 
 *  
 **/
require_once dirname(__FILE__) . '/../init.php';
require_once (ROOT_PATH . '/search/BasicSearch.php');

class DetailSearch extends BasicSearch{

    public function __construct($geotable_id, Console $console, $poi_id) {
        $this->setGeotableId($geotable_id);
        $this->setConsole($console);
        $this->setPoiId($poi_id);

        $this->url_ .= '/' . $this->poi_id_; 
    }

    public function setPoiId($id) {
        if (!is_numeric($id)) 
        {
            trigger_error('poi_id参数必须为数字类型', E_USER_ERROR);       
        }
        $this->poi_id_ = $id;
    } 

    protected function prepareNeedParams() {
    }

    protected $poi_id_;
    protected $url_ = '/geosearch/v2/detail';
}



/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
