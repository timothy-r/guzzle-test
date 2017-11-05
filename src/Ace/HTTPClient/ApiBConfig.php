<?php namespace Ace\HTTPClient;

/**
 * Class ApiBConfig
 * @package Ace\HTTPClient
 */
class ApiBConfig implements ConfigInterface
{

    /**
     * @param string $name
     * @return string
     */
    public function get($name)
    {
        switch ($name) {
            case 'profile':
                return 'user-1';
            case 'secret':
                return 'abcde12345';
            default:
                return '';
        }
    }
}