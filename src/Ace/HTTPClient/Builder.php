<?php namespace Ace\HTTPClient;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;

/**
 * Class Builder
 * @package Ace\HTTPClient
 */
abstract class Builder implements ClientBuilderInterface
{
    use BuilderFunctionTrait;

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
}