<?php

require '../vendor/autoload.php';

use liv\lbs\geodata\ColumnData;
use liv\lbs\geodata\GeotableData;
use liv\lbs\geodata\PoiData;
use liv\lbs\phplib\console\Console;


/*---------- Test Geotable ----------*/
function test_geotable(Console $console)
{
    $geotable = new GeotableData($console);
    $ret = $geotable->create("shop", 1, 1);
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
function test_column(Console $console, $geotable_id)
{
    $column = new ColumnData($console, $geotable_id);
    $ret = $column->create("test-01", "field01", $column::COLUMN_TYPE_INT, 1, 0);
    var_dump($ret);
    $id = $ret["id"];

    $ret = $column->update($id, "test-02");
    var_dump($ret);
    $ret = $column->list("test-01");
    var_dump($ret);

    $ret = $column->detail($id);
    var_dump($ret);

    $ret = $column->delete($id);
    var_dump($ret);
}

/*---------- Test Poi ----------*/
function test_poi(Console $console, $geotable_id)
{
    $column = new PoiData($console, $geotable_id);
    $ret = $column->create("test-01", "address", "tags tags", 40, 116, 1);
    var_dump($ret);
    $id = $ret["id"];

    $ret = $column->list(array("title" => "test-01"));
    var_dump($ret);

    $ret = $column->update($id, array("title" => "test-02"));
    var_dump($ret);


    $ret = $column->detail($id);
    var_dump($ret);

    $ret = $column->delete($id);
    var_dump($ret);
}

$console = new Console();
$console->setServerAK('KbMeaL3jz0ds1lbG11g3Esys', 'myGUcGyxhZvVOtINr8wrvkbGIxTb9CSG');


test_geotable($console);
$geotable_id = '116200';
test_column($console, $geotable_id);
test_poi($console, $geotable_id);