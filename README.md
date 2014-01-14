#DuoLingo API written in PHP

A very small API for talking to DuoLingo. Current functionality
only allows getting a list of words out. It could/will be expanded
in future.

##Example Usage 

<?php

$config = [
    'login' => 'DuoLingoUsername',
    'password' => 'DuoLingoPassword'
];

$duoLingoApi = new \alan01252\DuoLingoApi\DuoLingoApi($config);

//Pull a list of words from Duolingo ordered by strength ASC
foreach($duoLingoApi->getWordFinder()->getWords('strength', 'false' , 5) as $words) {
    var_dump($words); //Dumps an array of twenty words five times
}
