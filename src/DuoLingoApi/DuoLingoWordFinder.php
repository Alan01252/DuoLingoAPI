<?php
namespace alan01252\DuoLingoApi;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;

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
        return $request->send()->json();

    }

    /**
     * @param string $sortBy e.g strength
     * @param string $desc true/false
     * @param int $pageLimit total pages to return
     *
     * @return \Generator
     */
    public function getWords($sortBy = null, $desc = '', $pageLimit = null)
    {
        $i = 1;
        $foundWords = [];

        while ($words = $this->fetchWordsFromDuoLingo($i, $sortBy, $desc)['vocab']) {

            foreach ($words as $word) {
                $foundWords[] = $word['surface_form'];
            }

            yield $foundWords;

            $foundWords = [];

            $i++;

            if ($i === $pageLimit) {
                break;
            }
        }
    }

    public function getTotalKnownWords()
    {
       return $this->fetchWordsFromDuoLingo(1)['vocab_count'];
    }

}