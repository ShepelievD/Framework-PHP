<?php

namespace Framework\Response;

/**
 * The class gives a response
 *
 * Class Response
 * @package Framework\Response
 */


class Response {

    /**
     * Header's array for response
     *
     * @var array
     */

    protected $headers = [];

    /**
     * Code of response. At default is 200 that means success
     *
     * @var int
     */
    public $code = 200;

    public $content = '';

    /**
     * Type of response. At default is "text/html"
     *
     * @var string
     */
    public $type = 'text/html';

    /**
     * Associated array of code => description
     *
     * @var array
     */

    public static $codeMessage = [
        200 => 'OK',
        302 => 'FOUND',
        404 => 'NOT FOUND',
        500 => 'BAD RESPONSE',
    ];

    /**
     * Response constructor.
     *
     * @param string $content
     * @param string $type
     * @param int $code
     */

    public function __construct($content = '', $type = 'text/html', $code = 200){
        $this->code = $code;
        $this->content = $content;
        $this->type = $type;
        $this->setHeader('Content-Type', $this->type);
    }

    /**
     * The method's maintain is sending a response.
     */
    public function send(){
        $this->sendHeaders();
        $this->sendBody();
    }

    /**
     * Sets header of response
     *
     * @param $name
     * @param $value
     */

    public function setHeader($name, $value){
        $this->headers[$name] = $value;
    }

    /**
     * Sends header of response
     */

    public function sendHeaders(){

        header($_SERVER['SERVER_PROTOCOL'] . ' ' . $this->code. ' ' . self::$codeMessage[$this->code]);

        foreach($this->headers as $key => $value){
            header(sprintf("%s: %s", $key, $value));
        }
    }

    /**
     * Sends body of response
     */

    public function sendBody(){
        echo $this->content;
    }
}