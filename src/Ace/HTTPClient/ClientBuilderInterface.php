<?php namespace Ace\HTTPClient;

/**
 * Interface ClientBuilderInterface
 * @package Ace\HTTPClient
 */
interface ClientBuilderInterface
{

    /**
     * @return ClientBuilderInterface
     */
    public function begin();

    /**
     * @return ClientBuilderInterface
     */
    public function addAuthentication();

    /**
     * @return ClientBuilderInterface
     */
    public function addAccept();

    // public function addHeader($key, $value) ??

    /**
     * @return ClientBuilderInterface
     */
    public function addCaching();

    /**
     * @return \GuzzleHttp\Client
     */
    public function getProduct();
}