<?php
namespace Remitano\Api\Utils;
use GuzzleHttp\Psr7\Request;
require 'http_date.php';

class ApiAuthHandler
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    protected function setMD5HeaderOnRequest($request)
    {
        if (!$contentMD5 = $request->getHeader('content-md5')) {
            $body = $this->getRequestBody($request);
            $request = $request->withHeader('content-md5', $this->calculateMD5($body));
        }
        return $request;
    }

    protected function getRequestBody($request)
    {
        return (string) $request->getBody();
    }

    protected function calculateMD5($body)
    {
        return base64_encode(md5($body, true));
    }

    protected function setDateHeaderOnRequest($request)
    {
        if (!$date = $request->getHeader('date')) {
            $request = $request->withHeader('date', http_date());
        }
        return $request;
    }

    public function getCanonicalString($request)
    {
        $parts = array(
            $request->getMethod(),
            $request->getHeaderLine('content-type'),
            $request->getHeaderLine('content-md5'),
            $request->getRequestTarget(),
            $request->getHeaderLine('date')
        );
        return join(',', $parts);
    }

    public function getHMACSignature($request)
    {
        $canonicalString = $this->getCanonicalString($request);
        $s = hash_hmac('sha1', $canonicalString, $this->config['apiSecret'], true);
        $s = base64_encode($s);
        return trim($s);
    }

    public function setAuthorizationHeaderOnRequest($request)
    {
        $signature = $this->getHMACSignature($request);
        $authorized_header = "APIAuth {$this->config['apiKey']}:{$signature}";
        return $request->withHeader('Authorization', $authorized_header);
    }

    public function updateHeader($request)
    {
        $request = $request->withHeader('Content-Type','application/json');
        $request = $request->withHeader('Accept','application/json');
        $request = $this->setMD5HeaderOnRequest($request);
        $request= $this->setDateHeaderOnRequest($request);
        return $this->setAuthorizationHeaderOnRequest($request);
    }

    public function handleAuthorizationHeader()
    {
        return function (callable $handler)
        {
            return function ($request, array $options) use ($handler)
            {
                $request= $this->updateHeader($request);
                return $handler($request, $options);
            };
        };
    }
}
