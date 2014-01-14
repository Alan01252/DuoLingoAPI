<?php
namespace alan01252\DuoLingoApi;


class DuoLingoApi
{
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->client = new DuoLingoClient($config['login'], $config['password']);
        $this->wordFinder = new DuoLingoWordFinder($this->client);
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getWordFinder()
    {
        return $this->wordFinder;
    }

} 