<?php namespace Ace\HTTPClient;

/**
 * Class ApiAConfig
 * @package Ace\HTTPClient
 */
class ApiAConfig implements ConfigInterface
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
                return 'application/vnd.cool-api.com-v1+json';
            case 'region':
                return 'eu-west-2';
            case 'token':
                return 'myBigFatToken';
            default:
                return '';
        }
    }
}