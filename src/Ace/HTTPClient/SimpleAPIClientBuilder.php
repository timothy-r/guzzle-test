<?php namespace Ace\HTTPClient;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;

/**
 * Uses HTTP Basic Authentication
 */
class SimpleAPIClientBuilder implements ClientBuilderInterface
{
    use BuilderFunctionTrait;

    /**
     * @var HandlerStack
     */
    private $stack;

    /**
     * @var ConfigInterface
     */
    private $config;

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
    public function addAccept()
    {
        $this->stack->push(
            $this->addHeader(
                'Accept',
                $this->config->get('accept')
            )
        );

        return $this;
    }

    /**
     * @return $this
     */
    public function addAuthentication()
    {
        $value = $this->config->get('profile') . ':' . $this->config->get('password');

        $this->stack->push(
            $this->addHeader(
                'Authorization',
                'Basic ' . base64_encode($value)
            )
        );

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