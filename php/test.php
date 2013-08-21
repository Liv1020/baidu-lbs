<?php
/***************************************************************************
 * 
 * Copyright (c) 2013 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/
 
 
 
/**
 * @file test.php
 * @author wangjing14(com@baidu.com)
 * @date 2013/08/21 16:06:33
 * @brief 
 *  
 **/

require_once('./phplib/console/Console.php');
require_once('./search/NearbySearch.php');

$console = new Console();
$console->setServerAK('4b905df3330121f4382299f18cfc2462', '9E050DAfce0ca5861a01bda20bc8c234');

$search = new NearbySearch(31925, $console, '116.396809,39.907098', 1000);
var_dump($search->search());
/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
