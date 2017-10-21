<?php namespace Ace\HTTPClient;

/**
 * Provides configuration values
 */
interface ConfigInterface
{
    /**
     * @param string $name
     * @return string
     */
    public function get($name);

}