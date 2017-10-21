<?php namespace Ace\HTTPClient;

/**
 * Uses HTTP Basic Authentication and sets a configured Accept header
 */
class SimpleAPIClientBuilder extends Builder
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
        $value = $this->config->get('profile') . ':' . $this->config->get('secret');

        $this->stack->push(
            $this->addHeader(
                'Authorization',
                'Basic ' . base64_encode($value)
            )
        );

        return $this;
    }
}