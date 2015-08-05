<?php
namespace liv\lbs\search;

use liv\lbs\phplib\console\Console;

/**
 * Class DetailSearch
 * @package liv\lbs\search
 */
class DetailSearch extends BasicSearch
{
    /**
     * @var
     */
    protected $poi_id_;
    /**
     * @var string
     */
    protected $url_ = '/geosearch/v2/detail';

    /**
     * @param $geotable_id
     * @param Console $console
     * @param $poi_id
     */
    public function __construct($geotable_id, Console $console, $poi_id)
    {
        $this->setGeotableId($geotable_id);
        $this->setConsole($console);
        $this->setPoiId($poi_id);

        $this->url_ .= '/' . $this->poi_id_;
    }

    /**
     * @param $id
     */
    public function setPoiId($id)
    {
        if (!is_numeric($id)) {
            trigger_error('poi_id参数必须为数字类型', E_USER_ERROR);
        }
        $this->poi_id_ = $id;
    }

    /**
     *
     */
    protected function prepareNeedParams()
    {
    }
}