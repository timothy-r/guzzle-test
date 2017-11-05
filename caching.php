<?php
require_once ('./vendor/autoload.php');


/**
 * examples of caching responses with Guzzle 6
 */
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Psr7;

use Doctrine\Common\Cache\FilesystemCache;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;
use Kevinrob\GuzzleCache\Strategy\GreedyCacheStrategy;
use Kevinrob\GuzzleCache\Storage\DoctrineCacheStorage;
use Kevinrob\GuzzleCache\CacheMiddleware;

$handler = new CurlHandler();
$stack = HandlerStack::create($handler);

$stack->push(
    new CacheMiddleware(
        new GreedyCacheStrategy(
            new DoctrineCacheStorage(
                new FilesystemCache('/tmp/')
            )
        , 1800
        )
    ),
    'cache'
);


// Initialize the client with the handler option
$client = new Client(['handler' => $stack]);

$url = $argv[1];

$reponse = $client->get($url);

$str = Psr7\str($reponse);

var_dump($str);