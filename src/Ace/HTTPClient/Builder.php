<?php namespace Ace\HTTPClient;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
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
     * @return Client
     */
    public function getProduct()
    {
        return new Client(['handler' => $this->stack]);
    }

    /**
     * @param $header
     * @param $value
     * @return \Closure
     */
    protected function addHeader($header, $value)
    {
        return function (callable $handler) use ($header, $value) {
            return function (
                RequestInterface $request,
                array $options
            ) use ($handler, $header, $value) {
                $request = $request->withHeader($header, $value);
                return $handler($request, $options);
            };
        };
    }
}