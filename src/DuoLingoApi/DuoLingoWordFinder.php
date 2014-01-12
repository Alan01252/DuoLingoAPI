<?php
namespace alan01252\DuoLingoApi;

use Guzzle\Http\Client;

/**
 * Class DuoLingoWordFinder
 * @package alan01252\DuoLingoApi
 */
class DuoLingoWordFinder
{

    /**
     * @var DuoLingoClient
     */
    private $client;

    private $url = "/words";


    /**
     * @param DuoLingoClient $client
     */
    public function __construct(DuoLingoClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param int $page
     * @param string $sortBy
     * @param string $desc
     *
     * @return mixed
     */

    private function fetchWordsFromDuoLingo($page = 1, $sortBy = null, $desc = '')
    {
        $url = "{$this->url}?page={$page}&sort_by={$sortBy}&desc={$desc}";

        $this->client->login();
        $request = $this->client->getGuzzleClient()->get($url);
        $response = $request->send()->json();

        if (!isset($response['vocab'])) {
            return false;
        }

        return $response['vocab'];
    }

    /**
     * @param string $sortBy
     * @param string $desc
     * @param int $pageLimit
     *
     * @return \Generator
     */
    public function getWords($sortBy = null, $desc = '', $pageLimit = null)
    {
        $i = 1;
        $foundWords = [];

        $this->fetchWordsFromDuoLingo();

        while ($words = $this->fetchWordsFromDuoLingo($i, $sortBy, $desc)) {

            foreach ($words as $word) {
                $foundWords[] = $word['surface_form'];
            }

            yield $foundWords;

            $i++;

            if ($i === $pageLimit) {
                break;
            }
        }
    }

}