<?php namespace Ace\HTTPClient;

use Psr\Http\Message\RequestInterface;

/**
 * Uses HTTP Basic Authentication and sets a configured Accept header
 */
class ApiBClientBuilder extends ClientBuilder
{
    /**
     * @return $this
     */
    public function addAccept()
    {
        $this->addHeader('Accept', 'application/json');
        return $this;
    }

    /**
     * @return $this
     */
    public function addAuthentication()
    {
        $value = $this->config->get('profile') . ':' . $this->config->get('secret');

        $this->pushMiddleware(function (RequestInterface $request) use ($value) {
            return $request->withHeader('Authorization',  'Basic ' . base64_encode($value));
        });

        return $this;
    }
}