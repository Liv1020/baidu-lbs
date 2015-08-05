<?php

namespace liv\lbs\phplib\console;

/**
 * Class Console
 * @package liv\lbs\phplib
 */
class Console {

    /**
     * api 所必须的key
     * @var
     */
    private $ak_;

    /**
     * api 所必须的key
     * @var
     */
    private $sk_;

    /**
     * api 所必须的key
     * @var
     */
    private $keytype_;

    /**
     * 签名算法，适用于将ak配置成server类型，并且校验方式为sn
     * @var
     */
    private $sn_;

    /**
     * 移动端安全码，适用于将ak配置成mobile类型，android为 'sha1;packagename', ios为bundle
     * @var
     */
    private $mcode_;

    /**
     * http referer，适用于将ak配置成browser类型
     * @var
     */
    private $referer_;

    /**
     *
     */
    const SERVER_KEY = 1;
    /**
     *
     */
    const MOBILE_KEY = 2;
    /**
     *
     */
    const BROWSER_KEY = 3;

    /**
     * @param $ak
     * @param $sk
     */
    public function setServerAK($ak, $sk) {
        $this->ak_ = $ak;
        $this->sk_ = $sk;
        $this->keytype_ = Console::SERVER_KEY;
    }

    /**
     * @param $ak
     * @param $mcode
     */
    public function setMobileAK($ak, $mcode) {
        trigger_error('LBS云目前暂不支持Mobile类型的key');
    }

    /**
     * @param $ak
     * @param $referer
     */
    public function setBrowserAK($ak, $referer) {
        $this->ak_ = $ak;
        $this->referer_ = $referer;
        $this->keytype_ = Console::BROWSER_KEY;
    }

    /**
     * @return mixed
     */
    public function getAK() {
        return $this->ak_;
    }

    /**
     * @return mixed
     */
    public function getKeyType() {
        return $this->keytype_;
    }

    /**
     * @param $url
     * @param $queryArrays
     * @param string $method
     * @return string
     */
    public function caculateSN($url, $queryArrays, $method = 'GET') {
        if ($method === 'POST') 
        {
            ksort($queryArrays);
        }
        
        $queryString = http_build_query($queryArrays);
        $this->sn_ = md5(urlencode($url . '?' . $queryString . $this->sk_));
        return $this->sn_;
    }

    /**
     * @param $ak
     * @param $sk
     * @param $url
     * @param $queryArrays
     * @param string $method
     * @return string
     */
    public static function caculateAKSN($ak, $sk, $url, $queryArrays, $method = 'GET')
    {
        if ($method === 'POST') 
        {
            ksort($queryArrays);
        }           
                
        $queryString = http_build_query($queryArrays);
        return md5(urlencode($url . '?' . $queryString . $sk));
    }


    /**
     * @return mixed
     */
    public function getReferer() {
        return $this->referer_;
    }
}