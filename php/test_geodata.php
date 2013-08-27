<?php
/***************************************************************************
 * BSD License 
 * license : http://opensource.org/licenses/bsd-license.php
 **************************************************************************/
 
 
 
/**
 * @file test.php
 * @author fengzi(wfwq2008@gmail.com)
 * @date 2013/08/21 16:06:33
 * @brief 
 *  
 **/

require_once('./phplib/console/Console.php');
require_once('./geodata/GeotableData.php');
require_once('./geodata/ColumnData.php');
require_once('./geodata/PoiData.php');


/*---------- Test Geotable ----------*/
function test_geotable(Console $console){
    $geotable = new GeotableData($console);
    $ret = $geotable->create("test01", 1, 1);
    $id = $ret["id"];
    var_dump($ret);

    $ret = $geotable->update($id, "test02", 1, 1);
    var_dump($ret);

    $ret = $geotable->detail($id);
    var_dump($ret);

    $ret = $geotable->delete($id);
    var_dump($ret);

    $ret = $geotable->list("test");
    var_dump($ret);
}

/*---------- Test Column ----------*/
function test_column(Console $console, $geotable_id){
    $column = new ColumnData($console, $geotable_id);
    $ret = $column->create("test-01", "field01", 1, 1, 0);
    var_dump($ret);
    $id = $ret["id"];

    $ret = $column->update($id, "test-02");
    var_dump($ret);
    $ret = $column->list("test-01");
    //var_dump($ret);
   
    $ret = $column->detail($id);
    var_dump($ret);

    $ret = $column->delete($id);
    var_dump($ret);
}

/*---------- Test Poi ----------*/
function test_poi(Console $console, $geotable_id)
{
    $column = new PoiData($console, $geotable_id);
    $ret = $column->create("test-01", "address", "tags tags", 40, 116 , 1);
    var_dump($ret);
    $id = $ret["id"];

    $ret = $column->list(array("title"=>"test-01"));
    var_dump($ret);

    $ret = $column->update($id, array("title"=>"test-02"));
    var_dump($ret);
   
    
    $ret = $column->detail($id);
    var_dump($ret);

    $ret = $column->delete($id);
    var_dump($ret);
}

$console = new Console();
$console->setServerAK('4b905df3330121f4382299f18cfc2462', '9E050DAfce0ca5861a01bda20bc8c234');


test_geotable($console);
//test_column($console, $geotable_id);
//test_poi($console, $geotable_id);

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
