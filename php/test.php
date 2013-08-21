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
require_once('./search/LocalSearch.php');
require_once('./search/BoundSearch.php');
require_once('./search/DetailSearch.php');

$console = new Console();
$console->setServerAK('4b905df3330121f4382299f18cfc2462', '9E050DAfce0ca5861a01bda20bc8c234');

$search = new NearbySearch(31958, $console, '120.734879,31.288689', 100);
$nearby = $search->search();
var_dump($nearby);

$search = new LocalSearch(31958, $console, 1);
$search->setSortBy('ClickCount', BasicSearch::DESCEND);
$search->addFilter('ClickCount', 1, 100);
$search->addTags('华北');
$local = $search->search();

var_dump($local);

$search = new BoundSearch(31958, $console, '116.383801,39.90112', '116.412475,39.916451');
$bound = $search->search();

$search = new DetailSearch(31958, $console, 18460245);
$detail = $search->search();

var_dump($detail);
/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
