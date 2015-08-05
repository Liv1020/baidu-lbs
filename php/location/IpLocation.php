<?php
/**
 * User: Liv <523260513@qq.com>
 * Date: 15/8/5
 * Time: 下午5:27
 */

namespace liv\lbs\location;


use liv\lbs\geodata\BasicData;
use liv\lbs\phplib\console\Console;

class IpLocation extends BasicData
{
    /**
     * @var string
     */
    protected $url_ = '/location/';

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
            $this->params_ = array("geotable_id" => $this->geotable_id_);
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
     * @param $ip
     * @param $coor
     */
    protected function _ip($ip, $coor = 'bd09ll')
    {
        $this->params_['ip'] = $ip;
        $this->params_['coor'] = $coor;
    }

    /**
     * @return mixed
     */
    protected function prepareNeedParams()
    {

    }
}