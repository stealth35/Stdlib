<?php
/**
 * @namespace
 */
namespace Stdlib;

/**
 * @category Stdlib
 * @package  Stdlib
 * @author   stealth35
 */
class WebSocket
{
    protected $url;
    protected $protocols;
    protected $socket;

    /**
     * @param string $url
     * @param mixed $protocols
     * @throws \ErrorException
     */
    public function __construct($url, $protocols = array())
    {
        $this->url = $url;

        if(is_array($protocols))
        {
            $protocols = implode(', ', $protocols);
        }
        
        $this->protocols = $protocols;

        $url = (object) parse_url($url);

        if(empty($url->port))
        {
            if($url->scheme === 'ws')
            {
                $url->port = 80;
            }

            if($url->scheme === 'wss')
            {
                $url->port = 443;
            }
        }

        if(empty($url->path))
        {
            $url->path = '/';
        }

        $this->socket = @stream_socket_client("$url->host:$url->port", $errno, $errstr);

        if(!$this->socket)
        {
            throw new \ErrorException($errstr, $errno, E_USER_WARNING);
        }

        if($url->scheme === 'wss')
        {
            stream_socket_enable_crypto($this->socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
        }

        stream_set_blocking($this->socket, 0);

        $headers = array(
            "GET $url->path HTTP/1.1",
            'Upgrade: WebSocket',
            'Connection: Upgrade',
            "Host: $url->host:$url->port",
            'Origin: http://' . $_SERVER['HTTP_HOST'],
            'Sec-WebSocket-Key1: ' . $this->generateToken(),
            'Sec-WebSocket-Key2: ' . $this->generateToken(),
        );

        if($this->protocols)
        {
            $headers[] = "Sec-WebSocket-Protocol: $this->protocols";
        }

        $key3 = range("\x00", "\xFF");
        shuffle($key3);

        $header = implode("\r\n", $headers) . "\r\n\r\n" . implode('', array_slice($key3, 0, 8));

        fwrite($this->socket, $header);

        $r = array($this->socket);
        $w = $e = null;

        while(stream_select($r, $w, $e, 200));
    }

    /**
     * @param string $data
     */
    public function send($data)
    {
        fwrite($this->socket, "\x00$data\xFF");
    }

    public function close()
    {
        $r = array($this->socket);
        $w = $e = null;

        while(stream_select($r, $w, $e, 200));

        stream_socket_shutdown($this->socket, STREAM_SHUT_RDWR);
    }

    protected function generateToken()
    {
        $spaces = rand(1, 12);
        $number = rand(0, 4294967295 / $spaces);
        $key    = str_split($number * $spaces);
        $chars  = array_merge(range("\x21", "\x2F"), range("\x3A", "\x7E"));

        shuffle($chars);
        $randoms = array_slice($chars, 0, $spaces);

        foreach($randoms as $char)
        {
            $pos = rand(0, $spaces);
            array_splice($key, $pos, 0, array($char));

            $pos = rand(1, count($key) - 1);
            array_splice($key, $pos, 0, array(' '));
        }

        return implode($key);
    }
}