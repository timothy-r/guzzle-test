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
        $value = $this->config->get('accept');
        $this->addHeader('Accept', $value);
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

        $this->pushMiddleware(function (RequestInterface $request) use ($credentials, $signer) {
            return $signer->signRequest($request, $credentials);
        });

        return $this;
    }
}