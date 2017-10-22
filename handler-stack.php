<?php
require_once ('./vendor/autoload.php');

use Psr\Http\Message\RequestInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Client;

$stack = new HandlerStack();
$stack->setHandler(\GuzzleHttp\choose_handler());

$stack->push(Middleware::mapRequest(function (RequestInterface $r) {
    echo 'A';
    return $r;
}));

$stack->push(Middleware::mapRequest(function (RequestInterface $r) {
    echo 'B';
    return $r;
}));

$stack->push(Middleware::mapRequest(function (RequestInterface $r) {
    echo 'C';
    return $r;
}));

$client = new Client(['handler' => $stack]);
$client->request('POST', 'http://localhost:8000/');
// echoes 'ABC';

echo "\n";

$stack->unshift(Middleware::mapRequest(function (RequestInterface $r) {
    echo '0';
    return $r;
}));

$client = new Client(['handler' => $stack]);
$client->request('POST', 'http://localhost:8000/');
// echoes '0ABC';

echo "\n";