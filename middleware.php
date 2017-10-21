<?php
require_once ('./vendor/autoload.php');

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7;

function add_header($header, $value)
{
    return function (callable $handler) use ($header, $value) {
        return function (
            RequestInterface $request,
            array $options
        ) use ($handler, $header, $value) {
            $request = $request->withHeader($header, $value);
            return $handler($request, $options);
        };
    };
}

function add_http_basic_auth($profile, $password)
{
    return function (callable $handler) use ($profile, $password) {
        return function (
            RequestInterface $request,
            array $options
        ) use ($handler, $profile, $password) {
            $request = $request->withHeader("Authorization", 'Basic ' . base64_encode("$profile:$password"));
            return $handler($request, $options);
        };
    };
}

function add_aws_sig_auth($profile, $password)
{
    return function (callable $handler) use ($profile, $password) {
        return function (
            RequestInterface $request,
            array $options
        ) use ($handler, $profile, $password) {
            // generate signature here

            return $handler($request, $options);
        };
    };
}

/**
 * @param $account
 */
function add_auth($profile)
{
    // depending on $account add diff auth header(s)
    return add_http_basic_auth($profile, '1234');

}

function add_response_tolower_filter()
{
    return function (callable $handler) {
        return function (
            RequestInterface $request,
            array $options
        ) use ($handler) {

            $promise = $handler($request, $options);

            return $promise->then(
                function (ResponseInterface $response) {
                    // filter response body
                    $body = strtolower($response->getBody()->getContents());
                    $body = Psr7\stream_for($body);
                    return $response->withBody($body);
                }
            );
        };
    };
}

$handler = new CurlHandler();
$stack = HandlerStack::create($handler); // Wrap w/ middleware

$stack->push(add_header('X-Foo', 'bar'));
$stack->push(add_auth('Frank.Dougal@fiends.net'));

$stack->push(add_response_tolower_filter());

$client = new Client(['handler' => $stack]);

$url = $argv[1];

$reponse = $client->get($url);

$str = Psr7\str($reponse);

var_dump($str);

//var_dump($reponse->getBody()->getContents());
