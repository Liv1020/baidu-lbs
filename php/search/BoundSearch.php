<?php
namespace liv\lbs\search;

use liv\lbs\phplib\console\Console;

/**
 * Class BoundSearch
 * @package liv\lbs\search
 */
class BoundSearch extends BasicSearch
{

    /**
     * @var
     */
    protected $bounds_;
    /**
     * @var string
     */
    protected $url_ = '/geosearch/v3/bound';

    /**
     * @param $geotable_id
     * @param Console $console
     * @param $bottomleft
     * @param $upright
     */
    public function __construct($geotable_id, Console $console, $bottomleft, $upright)
    {
        $this->setGeotableId($geotable_id);
        $this->setConsole($console);
        $this->setBounds($bottomleft, $upright);
    }

    /**
     * @param $bl
     * @param $ur
     */
    public function setBounds($bl, $ur)
    {
        $this->cmpLocation($bl, $ur);
        $this->bounds_ = $bl . ';' . $ur;
    }

    /**
     * @param $loc
     */
    private function checkLocation($loc)
    {
        $tmp = explode(',', $loc);
        if (count($tmp) != 2) {
            trigger_error('参数必须是逗号分隔的经纬度信息', E_USER_ERROR);
        }

        if (!is_numeric($tmp[0]) || !is_numeric($tmp[1])) {
            trigger_error('经度或者纬度必须是数字类型', E_USER_ERROR);
        }
    }

    /**
     * @param $l
     * @param $r
     */
    private function cmpLocation($l, $r)
    {
        $this->checkLocation($l);
        $this->checkLocation($r);

        $ltmp = explode(',', $l);
        $rtmp = explode(',', $r);
        if (doubleval($ltmp[0]) < doubleval($rtmp[0])
            && doubleval($ltmp[1]) < doubleval($rtmp[1])
        ) {
            return;
        }

        trigger_error('参数必须是图区的左下角和右上角');
    }

    /**
     *
     */
    protected function prepareNeedParams()
    {
        $this->params_['bounds'] = $this->bounds_;
    }
}
