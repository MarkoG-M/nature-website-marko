<?php

function searchFlights($fromSkyId, $fromEntityId, $toSkyId, $toEntityId, $date){

    $url = "https://sky-scrapper.p.rapidapi.com/api/v2/flights/searchFlights"
        . "?originSkyId=$fromSkyId"
        . "&destinationSkyId=$toSkyId"
        . "&originEntityId=$fromEntityId"
        . "&destinationEntityId=$toEntityId"
        . "&date=$date"
        . "&cabinClass=economy"
        . "&adults=1"
        . "&sortBy=best"
        . "&currency=EUR"
        . "&market=de-DE"
        . "&countryCode=DE";

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "x-rapidapi-key: 1bf01a7084msh73b8a4ed38b0773p1f9964jsne3be1e92ef03",
            "x-rapidapi-host: sky-scrapper.p.rapidapi.com"
        ]
    ]);

    $response = curl_exec($curl);

    curl_close($curl);

    return json_decode($response, true);
}

function searchAirport($query){

    $url = "https://sky-scrapper.p.rapidapi.com/api/v1/flights/searchAirport?query="
        . urlencode($query);

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "x-rapidapi-key: 1bf01a7084msh73b8a4ed38b0773p1f9964jsne3be1e92ef03",
            "x-rapidapi-host: sky-scrapper.p.rapidapi.com"
        ]
    ]);

    $response = curl_exec($curl);

    curl_close($curl);

    return json_decode($response, true);
}