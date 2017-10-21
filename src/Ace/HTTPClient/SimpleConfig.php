<?php namespace Ace\HTTPClient;

/**
 * Class SimpleConfig
 * @package Ace\HTTPClient
 */
class SimpleConfig implements ConfigInterface
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
            case 'accept':
                return 'application/json';
            case 'region':
                return 'eu-west-2';
            case 'token':
                return 'myBigFatToken';
            default:
                return '';
        }
    }
}