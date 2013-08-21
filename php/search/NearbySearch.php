<?php
/***************************************************************************
 * BSD License 
 * http://opensource.org/licenses/bsd-license.php
 **************************************************************************/
 
/**
 * @file NearbySearch.php
 * @author wangjild(wangjild@gmail.com)
 * @date 2013/08/21 12:31:50
 * @brief 
 *  
 **/
require_once dirname(__FILE__) . '/../init.php';
require_once (ROOT_PATH . '/search/BasicSearch.php');

class NearbySearch extends BasicSearch{

    public function __construct($geotable_id, Console $console, $location, $radius = 500) {
        $this->setGeotableId($geotable_id);
        $this->setConsole($console);
        $this->setLocation($location);
        $this->setRadius($radius);
    }

    public function setLocation($location) {
        $tmp = explode(',', $location);
        if (count($tmp) !== 2) {
            trigger_error('location参数的格式必须为"经度,纬度"', E_USER_ERROR);
        }

        if (!is_numeric($tmp[0]) || !is_numeric($tmp[1])) 
        {
            trigger_error('经纬度必须为数字类型', E_USER_ERROR); 
        }

        $this->location_ = $location;
    } 

    public function setRadius($radius) 
    {
        if (!is_numeric($radius)) 
        {
            trigger_error('检索半径必须为数字类型', E_USER_ERROR);
        }

        $this->radius_ = $radius;
    }

    protected function prepareNeedParams() {
        $this->params_['location'] = $this->location_;
        $this->params_['radius'] = $this->radius_;
    }

    protected $location_;
    protected $url_ = '/geosearch/v2/nearby';
}



/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
