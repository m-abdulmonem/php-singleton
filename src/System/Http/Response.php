<?php
/**
 * Created by PhpStorm.
 * User: mohamed
 * Date: 20/06/17
 * Time: 08:11 م
 */

namespace Mabdulmonem\System\Http;


use Mabdulmonem\System\MAApplication;

class Response
{
    /**
     * Application Object
     *
     * @var \System\Application
     */
    private $app;
    /**
     * Headers Container That Will be Sent to browser
     *
     * @var array
     */
    private $headers = [];
    /**
     * The Content Will be sent to The Browser
     *
     * @var string
     */
    private $content = '';

    /**
     * Response constructor.
     *
     * @param MAApplication $app
     */
    public function __construct(MAApplication $app)
    {
        $this->app = $app;
    }

    /**
     * set The Response output content
     *
     * @param string $content
     * @return void
     */
    public function setOutput($content)
    {
        $this->content =$content;
    }

    /**
     * set The Response header
     *
     * @param string $header
     * @param mixed $value
     * @return void
     */
    public function setHeader($header,$value)
    {
        $this->headers[$header] = $value;
    }

    public function send()
    {
        $this->sendHeaders();
        $this->sendOutput();
    }

    public function json(mixed $value, int $status = 200): string|false
    {
        header('Content-Type: application/json', response_code: $status);
        return json_encode($value);
    }
    

    /**
     * send The response Header
     *
     * @return void
     */
    private function sendHeaders()
    {
        foreach ($this->headers as $header => $value){
            header($header .':'.$value);
        }
    }
    
    /**
     * send The response output
     *
     * @return void
     */
    private function sendOutput()
    {
        echo $this->content;
    }


}