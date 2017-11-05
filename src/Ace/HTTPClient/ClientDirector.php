<?php namespace Ace\HTTPClient;

/**
 */
class ClientDirector
{
    /**
     * @var ClientBuilderInterface
     */
    private $builder;

    /**
     * @param ClientBuilderInterface $builder
     */
    public function __construct(ClientBuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @return ClientBuilderInterface
     */
    public function construct()
    {
        return $this->builder->begin()->addAccept()->addAuthentication()->addCaching();
    }
}