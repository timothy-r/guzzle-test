<?php
require_once ('./vendor/autoload.php');

use GuzzleHttp\Psr7;
use Ace\HTTPClient\ClientDirector;
use Ace\HTTPClient\SimpleAPIClientBuilder;
use Ace\HTTPClient\SimpleConfig;

$url = $argv[1];

$config = new SimpleConfig();
$builder = new SimpleAPIClientBuilder($config);
$director = new ClientDirector($builder);

$builder = $director->construct();

$client = $builder->getProduct();

$reponse = $client->get($url);

$str = Psr7\str($reponse);

var_dump($str);