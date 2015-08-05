<?php

use liv\lbs\phplib\console\Console;
use liv\lbs\search\BasicSearch;
use liv\lbs\search\BoundSearch;
use liv\lbs\search\DetailSearch;
use liv\lbs\search\LocalSearch;
use liv\lbs\search\NearbySearch;

require '../vendor/autoload.php';

$console = new Console();
$console->setServerAK('KbMeaL3jz0ds1lbG11g3Esys', 'myGUcGyxhZvVOtINr8wrvkbGIxTb9CSG');
$geoTableId = '116200';

$search = new NearbySearch($geoTableId, $console, '120.734879,31.288689', 100);
$nearby = $search->search();
var_dump($nearby);

$search = new LocalSearch($geoTableId, $console, 1);
$search->setSortBy('ClickCount', BasicSearch::DESCEND);
$search->addFilter('ClickCount', 1, 100);
$search->addTags('华北');
$local = $search->search();

var_dump($local);

$search = new BoundSearch($geoTableId, $console, '116.383801,39.90112', '116.412475,39.916451');
$bound = $search->search();

$search = new DetailSearch($geoTableId, $console, 18460245);
$detail = $search->search();

var_dump($detail);