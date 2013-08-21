<?php
/***************************************************************************
 * BSD License 
 * http://opensource.org/licenses/bsd-license.php
 **************************************************************************/
 
/**
 * @file BoundSearch.php
 * @author wangjild(wangjild@gmail.com)
 * @date 2013/08/21 12:31:50
 * @brief 
 *  
 **/
require_once dirname(__FILE__) . '/../init.php';
require_once (ROOT_PATH . '/search/BasicSearch.php');

class BoundSearch extends BasicSearch{

    public function __construct($geotable_id, Console $console, $bottomleft, $upright) {
        $this->setGeotableId($geotable_id);
        $this->setConsole($console);
        $this->setBounds($bottomleft, $upright);
    }

    public function setBounds($bl, $ur) {
        $this->cmpLocation($bl, $ur);     
        $this->bounds_ = $bl . ';' . $ur;
    } 

    private function checkLocation($loc) {
        $tmp = explode(',', $loc);
        if (count($tmp) != 2) 
        {
            trigger_error('参数必须是逗号分隔的经纬度信息', E_USER_ERROR);
        }

        if (!is_numeric($tmp[0]) || !is_numeric($tmp[1]))
        {
            trigger_error('经度或者纬度必须是数字类型', E_USER_ERROR);
        }
    }

    private function cmpLocation($l, $r) 
    {
        $this->checkLocation($l);
        $this->checkLocation($r);

        $ltmp = explode(',', $l);
        $rtmp = explode(',', $r);
        if (doubleval($ltmp[0]) < doubleval($rtmp[0]) 
                && doubleval($ltmp[1]) < doubleval($rtmp[1]))
        {
            return ;
        }

        trigger_error('参数必须是图区的左下角和右上角');
    }

    protected function prepareNeedParams() {
        $this->params_['bounds'] = $this->bounds_;
    }

    protected $bounds_;
    protected $url_ = '/geosearch/v2/bound';
}



/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
