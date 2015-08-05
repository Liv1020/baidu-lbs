<?php
namespace liv\lbs\search;

use liv\lbs\phplib\console\Console;

/**
 * Class NearbySearch
 * @package liv\lbs\search
 */
class NearbySearch extends BasicSearch
{
    /**
     * @var
     */
    protected $location_;
    /**
     * @var string
     */
    protected $url_ = '/geosearch/v3/nearby';

    /**
     * @var
     */
    protected $radius_;

    /**
     * @param $geotable_id
     * @param Console $console
     * @param $location
     * @param int $radius
     */
    public function __construct($geotable_id, Console $console, $location, $radius = 500)
    {
        $this->setGeotableId($geotable_id);
        $this->setConsole($console);
        $this->setLocation($location);
        $this->setRadius($radius);
    }

    /**
     * @param $location
     */
    public function setLocation($location)
    {
        $tmp = explode(',', $location);
        if (count($tmp) !== 2) {
            trigger_error('location参数的格式必须为"经度,纬度"', E_USER_ERROR);
        }

        if (!is_numeric($tmp[0]) || !is_numeric($tmp[1])) {
            trigger_error('经纬度必须为数字类型', E_USER_ERROR);
        }

        $this->location_ = $location;
    }

    /**
     * @param $radius
     */
    public function setRadius($radius)
    {
        if (!is_numeric($radius)) {
            trigger_error('检索半径必须为数字类型', E_USER_ERROR);
        }

        $this->radius_ = $radius;
    }

    /**
     *
     */
    protected function prepareNeedParams()
    {
        $this->params_['location'] = $this->location_;
        $this->params_['radius'] = $this->radius_;
    }
}