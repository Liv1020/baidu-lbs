<?php
/***************************************************************************
 * 
 * Copyright (c) 2013 Baidu.com, Inc. All Rights Reserved
 * 
 **************************************************************************/
 
 
 
/**
 * @file init.php
 * @author wangjing14(com@baidu.com)
 * @date 2013/08/21 13:50:31
 * @brief 
 *  
 **/

if (!extension_loaded('curl.so')) {
    trigger_error('未加载curl扩展，请先安装curl扩展', E_USER_ERROR);
}

define ('ROOT_PATH', dirname(__FILE__));
define ('YUN_LIB_PATH', ROOT_PATH . '/phplib');

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
