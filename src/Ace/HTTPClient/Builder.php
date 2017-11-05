<?php namespace Ace\HTTPClient;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Middleware;

use Psr\Http\Message\RequestInterface;

/**
 * Class Builder
 * @package Ace\HTTPClient
 */
abstract class Builder implements ClientBuilderInterface
{
    /**
     * @var HandlerStack
     */
    protected $stack;

    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @return $this
     */
    public function begin()
    {
        $handler = new CurlHandler();
        $this->stack = HandlerStack::create($handler); // Wrap w/ middleware

        return $this;
    }



    /**
     * @return $this
     */
    public function addHeader($key, $value)
    {
        $this->pushMiddleware(function (RequestInterface $request) use ($key, $value) {
            return $request->withHeader($key,  $value);
        });
    }

    /**
     * @param callable $middleware
     */
    protected function pushMiddleware(callable $middleware)
    {
        $this->stack->push(Middleware::mapRequest($middleware));
    }

    /**
     * @return $this
     */
    public function addCaching()
    {
        return $this;
    }

    /**
     * @return Client
     */
    public function getProduct()
    {
        return new Client(['handler' => $this->stack]);
    }
}