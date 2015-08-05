<?php
/**
 * User: Liv <523260513@qq.com>
 * Date: 15/8/5
 * Time: 下午5:42
 */
use liv\lbs\location\IpLocation;
use liv\lbs\phplib\console\Console;

require '../vendor/autoload.php';

$console = new Console();
$console->setServerAK('KbMeaL3jz0ds1lbG11g3Esys', 'myGUcGyxhZvVOtINr8wrvkbGIxTb9CSG');

$location = new IpLocation($console);
$res = $location->ip('202.198.16.3');

var_dump($res);