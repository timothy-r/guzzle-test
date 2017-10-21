<?php namespace Ace\HTTPClient;

use Aws\Credentials\Credentials;
use Aws\Signature\SignatureProvider;
use Psr\Http\Message\RequestInterface;

/**
 * Uses HTTP Basic Authentication and sets a configured Accept header
 */
class SignatureAPIClientBuilder extends Builder
{

    /**
     * @return $this
     */
    public function addAccept()
    {
        $this->stack->push(
            $this->addHeader(
                'Accept',
                $this->config->get('accept')
            )
        );

        return $this;
    }

    /**
     * @return $this
     */
    public function addAuthentication()
    {
        $credentials = new Credentials(
            $this->config->get('profile'),
            $this->config->get('secret'),
            $this->config->get('token')
        );

        $provider = SignatureProvider::defaultProvider();
        $signer = $provider('v4', 'sig-auth', $this->config->get('region'));

        $func = function (callable $handler) use ($credentials, $signer) {
            return function (
                RequestInterface $request,
                array $options
            ) use ($handler, $credentials, $signer) {
                $request = $signer->signRequest($request, $credentials);
                return $handler($request, $options);
            };
        };

        $this->stack->push($func);

        return $this;
    }
}