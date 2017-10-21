<?php namespace Ace\HTTPClient;

use Psr\Http\Message\RequestInterface;

/**
 * @author timrodger
 * Date: 21/10/2017
 */
trait BuilderFunctionTrait
{
    /**
     * @param $header
     * @param $value
     * @return \Closure
     */
    protected function addHeader($header, $value)
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
}