<?php
/***************************************************************************
 * BSD License 
 * http://opensource.org/licenses/bsd-license.php
 **************************************************************************/
 
/**
 * @file GeotableData.php
 * @author fengzi(wfwq2008@gmail.com)
 * @date 2013/08/21 12:31:50
 * @brief 
 *  
 **/
require_once dirname(__FILE__) . '/../init.php';
require_once (ROOT_PATH . '/geodata/BasicData.php');

class PoiData extends BasicData{

    public function __construct(Console $console, $geotable_id) {
        $this->setConsole($console);
        $this->geotable_id_ = $geotable_id;
    }

    public function __call($action, $args){
		if (method_exists($this, "_".$action)) {
            $this->params_    = array("geotable_id"=>$this->geotable_id_);
			$ret = call_user_func_array(array (
				$this,
				"_" . $action
			), $args);

            $this->setAction($action);
            return $this->request();
        }else{
            return array("status"=>-1, "message"=>"method不存在");
        }
    }

    /**
     * create 
     * 
     * @param $title    poi名称 string(256) 可选 。
     * @param address  地址    string(256) 可选 。
     * @param tags tags    string(256) 可选 。
     * @param latitude 用户上传的纬度  double  必选 。
     * @param longitude    用户上传的经度  double  必选 。
     * @param coord_type   用户上传的坐标的类型    uint32  1：未加密的GPS坐标 2：国测局加密 3：百度加密 必选
     * @access public
     * @return void
     */
    protected function _create($title, $address, $tags, $latitude, $longitude, $coord_type, $options=array()){
        $this->params_['title'] = $title; 
        $this->params_['address'] = $address; 
        $this->params_['tags'] = $tags; 
        $this->params_['latitude'] = $latitude; 
        $this->params_['longitude'] = $longitude; 
        $this->params_['coord_type'] = $coord_type; 

        foreach($options as $k=>$v){
            $this->params_[$k] = $v;
        }
    }

    protected function _update($id, $options=array()){
        $this->params_['id']    = $id;
        foreach($options as $k=>$v){
            $this->params_[$k] = $v;
        }
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
    protected function _delete($id){
        $this->params_['id']    = $id;
    }

    /**
     * detail 
     * 查询指定id表（detail geotable）接口
     * 
     * @param mixed $id 指定geotable的id
     * @access public
     * @return void
     */
    protected function _detail($id){
        $this->params_['id']    = $id;
    }

        
    /**
     * list 
     * 查询表（list geotable）接口     
     * http://developer.baidu.com/map/lbs-geodata.htm#.poi.manage2.2
     * 
     * @param mixed $title 可选
     * @param mixed $tags 可选
     * @param mixed $格式x1,y1;x2,y2分别代表矩形的左上角和右下角 可选
     * @access public
     * @return void
     */
    protected function _list($options=array()){
        foreach($options as $k=>$v){
            $this->params_[$k] = $v;
        }
    }

    protected function prepareNeedParams() {
        //$this->params_['region'] = $this->region_;
    }

    protected $url_ = '/geodata/v2/poi/';
}



/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
