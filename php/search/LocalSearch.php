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

class LocalSearch extends BasicSearch{

    public function __construct($geotable_id, Console $console, $region) {
        $this->setGeotableId($geotable_id);
        $this->setConsole($console);
        $this->setRegion($region);
    }

    public function setRegion($region) {
        if (!is_string($region) && !is_numeric($region)) 
        {
            trigger_error('region参数必须为地区名称或者百度地区编码');       
        }
        $this->region_ = $region;
    } 

    protected function prepareNeedParams() {
        $this->params_['region'] = $this->region_;
    }

    protected $region_;
    protected $url_ = '/geosearch/v2/local';
}



/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
