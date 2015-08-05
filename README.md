Baidu LBS云 SDK
==================

Baidu LBS云 SDK 提供了一个基于PHP/Java语言的，封装了百度[LBS云](http://lbsyun.baidu.com)各个服务SDK。

感谢：[wangjild](https://github.com/wangjild/lbsyunsdk-baidu)

更新：1、使用composer
     2、添加命名空间
     3、优化注释
     4、优化部分代码逻辑

## 目录
-----------------
1. [安装/配置](#安装/配置)
    
    composer require liv/baidu-lbs
    
2. [使用方法](#使用方法)
    
    2.1 [存储]
    
        ```php
        
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
        
        ```

    2.1 [检索](#检索)

        ```php
        
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
        
        ```
