<?php
require_once ('./vendor/autoload.php');

use GuzzleHttp\Psr7;
use Ace\HTTPClient\ClientDirector;
use Ace\HTTPClient\SimpleAPIClientBuilder;
use Ace\HTTPClient\SimpleConfig;
use Ace\HTTPClient\SignatureAPIClientBuilder;

$url = $argv[1];

$client = getClient($url);

$reponse = $client->get($url);

$str = Psr7\str($reponse);

var_dump($str);

function getClient($api)
{
    $config = new SimpleConfig();
    $builder = new SignatureAPIClientBuilder($config);
    $director = new ClientDirector($builder);

    $builder = $director->construct();

    return $builder->getProduct();

}