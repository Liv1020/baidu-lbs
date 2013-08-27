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

class ColumnData extends BasicData{

    public function __construct(Console $console, $geotable_id) {
        $this->setConsole($console);
        $this->geotable_id_ = $geotable_id;
    }

    public function __call($action, $args){
		if (method_exists($this, "_".$action)) {
            $this->params_ = array("geotable_id"=>$this->geotable_id_);
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
     * @param name column的属性中文名称    string(45)  必选
     * @param key  column存储的属性key string(45)  必选，同一个geotable内的名字不能相同
     * @param type 存储的值的类型  uint32  必选，枚举值1： Int64, 2:double, 3,string
     * @param options array()
     *      @max_length   最大长度    uint32  最大值2048，最小值为1，针对string有效，并且string时必填。此值代表utf8的汉字个数，不是字节个数
     *      @default_value    默认值  string(45)  设置默认值
     *      @is_sortfilter_field  是否检索引擎的数值排序筛选字段  uint32  1,代表支持，0为不支持。默认为0。只有int或者double可以设置
     *      @is_search_field  是否检索引擎的文本检索字段  uint32  1,代表支持，0为不支持。默认为0，只有string可以设置检索字段只能用于字符串类型的列且最大长度不能超过512个字节
     *      @is_index_field   是否存储引擎的索引字段  uint32  用于存储接口查询:1,代表支持，0为不支持。默认为0
     * @access public
     * @return void
     */
    protected function _create($name, $key, $type, $is_sortfilter_field, $is_search_field, $options=array()){
        if (!($is_sortfilter_field == 0 || $is_sortfilter_field == 1 )){
            $msg = '必须字段is_sortfilter_field  是否检索引擎的数值排序筛选字段  uint32  1,代表支持，0为不支持。只有int或者double可以设置';
            trigger_error($msg, E_USER_WARNING);
            return array("status"=>-1, "message"=>$msg);
        }
        if (!($is_search_field== 0 || $is_search_field== 1 )){
            $msg = '必须字段is_search_field 是否检索引擎的文本检索字段  uint32  1,代表支持，0为不支持。默认为0，只有string可以设置检索字段只能用于字符串类型的列且最大长度不能超过512个字节';
            trigger_error($msg, E_USER_WARNING);
            return array("status"=>-1, "message"=>$msg);
        }
        $this->params_['name'] = $name; 
        $this->params_['key'] = $key;
        $this->params_['type'] = $type; 
        $this->params_['is_sortfilter_field'] = $is_sortfilter_field; 
        $this->params_['is_search_field'] = $is_search_field; 

        foreach($options as $k=>$v){
            $this->params_[$k] = $v;
        }
    }

    /**
     * update 
     * 修改指定条件列（column）接口
     * 
     * @param $id   列主键  uint32  必选。
     * @param $name 属性中文名称    string(45)  可选。
     * @param $default_value    默认值  string  可选。
     * @param $max_length   文本最大长度    int32   字符串最大长度。只能改大，不能改小
     * @param $is_sortfilter_field  是否检索引擎的数值排序字段  boolean 可能会引起批量操作
     * @param $is_search_field  是否检索引擎的文本检索字段  boolean 会引起批量操作
     * @param $is_index_field   是否存储引擎的索引字段  boolean  
     * @access protected
     * @return void
     */
    protected function _update($id, $name, $options=array()){
        $this->setMethod("POST");
    
        $this->params_['id']    = $id;
        $this->params_['name'] = $name; 

        foreach($options as $k=>$v){
            $this->params_[$k] = $v;
        }
    }

    /**
     * delete 
     * 删除指定条件列（column）接口 会触发批量操作
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
     * 查询指定id列（detail column） 
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
     * http://developer.baidu.com/map/lbs-geodata.htm#.poi.manage2.7 
     * 
     * @param $name geotable meta的属性中文名称 string(45)  可选
     * @param $key  geotable meta存储的属性key  string(45)  可选
     * @access public
     * @return void
     */
    protected function _list($name=null, $key=null){
        $this->params_['name'] = $name;
    }

    protected function prepareNeedParams() {
        //$this->params_['region'] = $this->region_;
    }

    protected $url_ = '/geodata/v2/column/';

}



/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
