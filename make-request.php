<?php
require_once ('./vendor/autoload.php');

use GuzzleHttp\Psr7;
use Ace\HTTPClient\ClientDirector;
use Ace\HTTPClient\ApiBClientBuilder;
use Ace\HTTPClient\ApiBConfig;
use Ace\HTTPClient\ApiAClientBuilder;
use Ace\HTTPClient\ApiAConfig;

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
            $builder = new ApiAClientBuilder(new ApiAConfig());
            break;
        case 'b':
            $builder = new ApiBClientBuilder(new ApiBConfig());
            break;
        default:
            throw new Exception("Unknown API: $api");
    }

    $director = new ClientDirector($builder);
    $builder = $director->construct();
    return $builder->getProduct();
}