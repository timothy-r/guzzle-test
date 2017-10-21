<?php namespace Ace\HTTPClient;

use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Middleware;

/**
 * Uses HTTP Basic Authentication and sets a configured Accept header
 */
class SimpleAPIClientBuilder extends Builder
{

    /**
     * @return $this
     */
    public function addAccept()
    {
        $value = $this->config->get('accept');

        $this->stack->push(Middleware::mapRequest(function (RequestInterface $request) use ($value) {
            return $request->withHeader('Accept',  $value);
        }));

        return $this;
    }

    /**
     * @return $this
     */
    public function addAuthentication()
    {
        $value = $this->config->get('profile') . ':' . $this->config->get('secret');

        $this->stack->push(Middleware::mapRequest(function (RequestInterface $request) use ($value) {
            return $request->withHeader('Authorization',  'Basic ' . base64_encode($value));
        }));

        return $this;
    }
}