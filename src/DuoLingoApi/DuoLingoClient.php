<?php
namespace alan01252\DuoLingoApi;

use Guzzle\Http\Client;

class DuoLingoClient
{
    /**
     * @var string
     */
    private $duoLingoUrl = "http://www.duolingo.com/";

    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $password;

    /**
     * @var Client
     */
    private $client;

    public function __construct($login, $password)
    {
        $this->login = $login;
        $this->password = $password;
    }

    private function createClient()
    {
        $this->client = new Client($this->duoLingoUrl);

        $cookieJar = new \Guzzle\Plugin\Cookie\CookieJar\ArrayCookieJar();
        $cookiePlugin = new \Guzzle\Plugin\Cookie\CookiePlugin($cookieJar);

        $this->client->addSubscriber($cookiePlugin);

        return $this;
    }

    public function login()
    {
        $this->createClient();

        $postData = [
            'login'    => $this->login,
            'password' => $this->password,
            '='        => 'login'
        ];

        $request = $this->client->post('/login', [], $postData);
        $response = $request->send()->json();

        if ($response['response'] !== "OK") {
           throw new \Exception("Unable to login");
        }

        return true;
    }

    public function getGuzzleClient()
    {
        return $this->client;
    }


}