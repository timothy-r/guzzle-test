<?php

use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request as Psr7Request;
use GuzzleHttp\Psr7\Response as Psr7Response;

use Psr\Log\LoggerInterface;
use Monolog\Logger;

const MAX_RETRIES = 5;

require_once __DIR__ . '/vendor/autoload.php';

/**
 * @param LoggerInterface $logger
 * @return Client
 */
function createHttpClient(LoggerInterface $logger)
{
    $stack = HandlerStack::create(new CurlHandler());
    $stack->push(\GuzzleHttp\Middleware::retry(createRetryHandler($logger)));
    $client = new Client([
        'handler' => $stack,
    ]);
    return $client;
}

function createRetryHandler(LoggerInterface $logger)
{
    return function (
        $retries,
        Psr7Request $request,
        Psr7Response $response = null,
        RequestException $exception = null
    ) use ($logger) {

        if ($retries >= MAX_RETRIES) {
            return false;
        }

        if (!(isServerError($response) || isConnectError($exception))) {
            return false;
        }

        $logger->warning(sprintf(
            'Retrying %s %s %s/%s, %s',
            $request->getMethod(),
            $request->getUri(),
            $retries + 1,
            MAX_RETRIES,
            $response ? 'status code: ' . $response->getStatusCode() : $exception->getMessage()
        ), [$request->getHeader('Host')[0]]);

        return true;
    };
}

/**
 * @param Psr7Response $response
 * @return bool
 */
function isServerError(Psr7Response $response = null)
{
    return $response && $response->getStatusCode() >= 500;
}

/**
 * @param RequestException $exception
 * @return bool
 */
function isConnectError(RequestException $exception = null)
{
    return $exception instanceof ConnectException;
}


$url = $argv[1];

$logger = new Logger('retry-logger', [], []);

$client = createHttpClient($logger);

$reponse = $client->get($url . "?retry=1");

$str = Psr7\str($reponse);

var_dump($str);