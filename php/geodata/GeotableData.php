<?php
namespace liv\lbs\geodata;

use liv\lbs\phplib\console\Console;

/**
 * Class GeotableData
 * @package liv\lbs\geodata
 * @method array create($name, $geotype, $is_published)
 * @method array update($id, $name, $geotype, $is_published)
 * @method array delete($id)
 * @method array detail($id)
 * @method array list($name = null)
 */
class GeotableData extends BasicData
{
    /**
     * @var string
     */
    protected $url_ = '/geodata/v3/geotable/';

    /**
     * @param Console $console
     */
    public function __construct(Console $console)
    {
        $this->setConsole($console);
    }

    /**
     * @param $action
     * @param $args
     * @return array|bool|mixed
     */
    public function __call($action, $args)
    {
        if (method_exists($this, "_" . $action)) {
            $this->params_ = array();
            $ret = call_user_func_array(array(
                $this,
                "_" . $action
            ), $args);

            $this->setAction($action);
            return $this->request();
        } else {
            return array("status" => -1, "message" => "method不存在");
        }
    }

    /**
     * create
     *
     * @param mixed $name geotable的中文名称
     * @param mixed $geotype geotable持有数据的类型 [1：点poi 2：线poi 3：面poi]
     * @param mixed $is_published 是否发布到检索 [0：未自动发布到云检索，1：自动发布到云检索；]
     * @access public
     * @return void
     */
    protected function _create($name, $geotype, $is_published)
    {
        $this->setMethod("POST");

        $this->params_['name'] = $name;
        $this->params_['geotype'] = $geotype;
        $this->params_['is_published'] = $is_published;
    }

    /**
     * @param $id
     * @param $name
     * @param $geotype
     * @param $is_published
     */
    protected function _update($id, $name, $geotype, $is_published)
    {
        $this->setMethod("POST");

        $this->params_['id'] = $id;
        $this->params_['name'] = $name;
        $this->params_['geotype'] = $geotype;
        $this->params_['is_published'] = $is_published;
    }

    /**
     * delete
     * 删除表（geotable）
     * 注：当geotable里面没有有效数据时，才能删除geotable
     *
     * @param mixed $id
     * @access public
     * @return void
     */
    protected function _delete($id)
    {
        $this->setMethod("POST");
        $this->params_['id'] = $id;
    }

    /**
     * detail
     * 查询指定id表（detail geotable）接口
     *
     * @param mixed $id 指定geotable的id
     * @access public
     * @return void
     */
    protected function _detail($id)
    {
        $this->params_['id'] = $id;
        $this->setMethod("GET");
    }


    /**
     * list
     * 查询表（list geotable）接口
     * http://developer.baidu.com/map/lbs-geodata.htm#.poi.manage2.2
     *
     * @param string|null $name 可选
     * @access public
     * @return void
     */
    protected function _list($name = null)
    {
        $this->params_['name'] = $name;
        $this->setMethod("GET");
    }

    /**
     *
     */
    protected function prepareNeedParams()
    {
        //$this->params_['region'] = $this->region_;
    }
}