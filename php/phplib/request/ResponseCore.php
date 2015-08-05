<?php
/**
 * User: Liv <523260513@qq.com>
 * Date: 15/8/5
 * Time: 上午10:39
 */

namespace liv\lbs\phplib\request;


/**
 * Container for all response-related methods.
 */
class ResponseCore
{
    /**
     * Stores the HTTP header information.
     */
    public $header;

    /**
     * Stores the SimpleXML response.
     */
    public $body;

    /**
     * Stores the HTTP response code.
     */
    public $status;

    /**
     * Constructs a new instance of this class.
     *
     * @param array $header (Required) Associative array of HTTP headers (typically returned by <RequestCore::get_response_header()>).
     * @param string $body (Required) XML-formatted response from AWS.
     * @param integer $status (Optional) HTTP response status code from the request.
     */
    public function __construct($header, $body, $status = null)
    {
        $this->header = $header;
        $this->body = $body;
        $this->status = $status;

        return $this;
    }

    /**
     * Did we receive the status code we expected?
     *
     * @param integer|array $codes (Optional) The status code(s) to expect. Pass an <php:integer> for a single acceptable value, or an <php:array> of integers for multiple acceptable values.
     * @return boolean Whether we received the expected status code or not.
     */
    public function isOK($codes = array(200, 201, 204, 206))
    {
        if (is_array($codes))
        {
            return in_array($this->status, $codes);
        }

        return $this->status === $codes;
    }
}