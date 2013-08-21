<?php
/***************************************************************************
 * BSD License 
 * license : http://opensource.org/licenses/bsd-license.php
 **************************************************************************/
 
 
 
/**
 * @file test.php
 * @author wangjild(wangjild@gmail.com)
 * @date 2013/08/21 16:06:33
 * @brief 
 *  
 **/

require_once('./phplib/console/Console.php');
require_once('./search/NearbySearch.php');

$console = new Console();
$console->setBrowserAK('4b905df3330121f4382299f18cfc2462', 'www.baidu.com');

$search = new NearbySearch(31925, $console, '116.396809,39.907098', 1000);
var_dump($search->search());

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
