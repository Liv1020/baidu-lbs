<?php
/***************************************************************************
 * BSD License 
 * license : http://opensource.org/licenses/bsd-license.php
 **************************************************************************/
 
/**
 * @file Console.php
 * @author wangjild(wangjild@gmail.com)
 * @date 2013/08/21 12:15:13
 * @brief 
 *  
 **/

class Console {

    public function setServerAK($ak, $sk) {
        $this->ak_ = $ak;
        $this->sk_ = $sk;
        $this->keytype_ = Console::SERVER_KEY;
    }

    public function setMobileAK($ak, $mcode) {
        trigger_error('LBS云目前暂不支持Mobile类型的key');
    }

    public function setBrowserAK($ak, $referer) {
        $this->ak_ = $ak;
        $this->referer_ = $referer;
        $this->keytype_ = Console::BROWSER_KEY;
    }

    public function getAK() {
        return $this->ak_;
    }

    public function getKeyType() {
        return $this->keytype_;
    }

    public function caculateSN($url, $querystring_arrays, $method = 'GET') {
        if ($method === 'POST') 
        {
            ksort($querystring_arrays);
        }
        
        $querystring = http_build_query($querystring_arrays);
        $this->sn_ = md5(urlencode($url.'?'.$querystring.$this->sk_));
        return $this->sn_;
    }

    public static function caculateAKSN($ak, $sk, $url, $querystring_arrays, $method = 'GET') 
    {
        if ($method === 'POST') 
        {
            ksort($querystring_arrays); 
        }           
                
        $querystring = http_build_query($querystring_arrays);
        return md5(urlencode($url.'?'.$querystring.$sk));
    }


    public function getReferer() {
        return $this->referer_;
    }

    /* api 所必须的key */
    private $ak_;
    private $sk_;

    private $keytype_;

    /*签名算法，适用于将ak配置成server类型，并且校验方式为sn*/
    private $sn_;

    /*移动端安全码，适用于将ak配置成mobile类型，android为 'sha1;packagename', ios为bundle*/
    private $mcode_;

    /*http referer，适用于将ak配置成browser类型*/
    private $referer_;

    const SERVER_KEY = 1;
    const MOBILE_KEY = 2;
    const BROWSER_KEY = 3;
}

/* vim: set expandtab ts=4 sw=4 sts=4 tw=100: */
?>
