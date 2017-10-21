<?php
require_once ('./vendor/autoload.php');

use GuzzleHttp\Psr7;
use Ace\HTTPClient\ClientDirector;
use Ace\HTTPClient\SimpleAPIClientBuilder;
use Ace\HTTPClient\SimpleConfig;
use Ace\HTTPClient\SignatureAPIClientBuilder;
use Ace\HTTPClient\SignatureConfig;

$api = $argv[1];
$url = $argv[2];

$client = getClient($api);

$reponse = $client->get($url);

$str = Psr7\str($reponse);

var_dump($str);

/**
 * In real life these would be DI services
 * @param $api
 * @return \GuzzleHttp\Client
 * @throws Exception
 */
function getClient($api)
{
    switch($api) {
        case 'a':
            $config = new SignatureConfig();
            $builder = new SignatureAPIClientBuilder($config);
            break;
        case 'b':
            $config = new SimpleConfig();
            $builder = new SimpleAPIClientBuilder($config);
            break;
        default:
            throw new Exception("Unknown API: $api");
    }

    $director = new ClientDirector($builder);
    $builder = $director->construct();
    return $builder->getProduct();
}