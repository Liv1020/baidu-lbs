<?php
namespace liv\lbs\search;


use liv\lbs\phplib\console\Console;

/**
 * Class LocalSearch
 * @package liv\lbs\search
 */
class LocalSearch extends BasicSearch
{

    /**
     * @var
     */
    protected $region_;
    /**
     * @var string
     */
    protected $url_ = '/geosearch/v3/local';

    /**
     * @param $geotable_id
     * @param Console $console
     * @param $region
     */
    public function __construct($geotable_id, Console $console, $region)
    {
        $this->setGeotableId($geotable_id);
        $this->setConsole($console);
        $this->setRegion($region);
    }

    /**
     * @param $region
     */
    public function setRegion($region)
    {
        if (!is_string($region) && !is_numeric($region)) {
            trigger_error('region参数必须为地区名称或者百度地区编码');
        }
        $this->region_ = $region;
    }

    /**
     *
     */
    protected function prepareNeedParams()
    {
        $this->params_['region'] = $this->region_;
    }
}