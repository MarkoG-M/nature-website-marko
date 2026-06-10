<?php

const FLIGHT_API_KEY = "6a2725d2bd74d3643f5874ea";
const FLIGHT_API_BASE_URL = "https://api.flightapi.io/roundtrip";
const FLIGHT_API_ATTEMPTS = 2;
const FLIGHT_API_RETRY_DELAY_SECONDS = 2;

function searchFlights($departureAirportCode, $arrivalAirportCode, $departureDate, $returnDate, $adults = 1, $children = 0, $infants = 0, $cabinClass = "Economy", $currency = "EUR"){
    // KI-Teil Start: dynamische FlightAPI-URL und cURL-Anfrage.
    $parts = [
        FLIGHT_API_BASE_URL,
        rawurlencode(FLIGHT_API_KEY),
        rawurlencode(strtoupper($departureAirportCode)),
        rawurlencode(strtoupper($arrivalAirportCode)),
        rawurlencode($departureDate),
        rawurlencode($returnDate),
        rawurlencode((string)$adults),
        rawurlencode((string)$children),
        rawurlencode((string)$infants),
        rawurlencode($cabinClass),
        rawurlencode($currency)
    ];

    $url = implode("/", $parts);
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30
    ]);

    $response = curl_exec($curl);
    $error = curl_error($curl);
    $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);

    if($response === false){
        return [
            "error" => "API Anfrage fehlgeschlagen: " . $error
        ];
    }

    $data = json_decode($response, true);

    if(json_last_error() !== JSON_ERROR_NONE){
        return [
            "error" => "API Antwort konnte nicht gelesen werden.",
            "raw" => $response
        ];
    }

    if($statusCode >= 400){
        $message = $data["message"] ?? $data["error"] ?? "FlightAPI Fehler";

        return [
            "error" => $message,
            "status" => $statusCode,
            "response" => $data
        ];
    }

    return $data;
    // KI-Teil Ende
}

function searchFlightsStable($departureAirportCode, $arrivalAirportCode, $departureDate, $returnDate, $adults = 1, $children = 0, $infants = 0, $cabinClass = "Economy", $currency = "EUR"){
    // KI-Teil Start: mehrere API-Versuche, damit die Suche moeglichst vollstaendig ist.
    $bestFlights = [];
    $lastError = null;

    for($attempt = 1; $attempt <= FLIGHT_API_ATTEMPTS; $attempt++){
        $data = searchFlights($departureAirportCode, $arrivalAirportCode, $departureDate, $returnDate, $adults, $children, $infants, $cabinClass, $currency);

        if(isset($data["error"])){
            $lastError = $data;
        } else {
            $flights = normalizeFlightApiResults($data, $currency);

            if(count($flights) > count($bestFlights)){
                $bestFlights = $flights;
            }
        }

        if($attempt < FLIGHT_API_ATTEMPTS){
            sleep(FLIGHT_API_RETRY_DELAY_SECONDS);
        }
    }

    if(count($bestFlights) > 0){
        return [
            "flights" => $bestFlights
        ];
    }

    return [
        "error" => $lastError["error"] ?? "Keine Flüge gefunden."
    ];
    // KI-Teil Ende
}

function normalizeFlightApiResults($data, $currency = "EUR"){
    // KI-Teil Start: verschachtelte API-Antwort in einfache Frontend-Daten umwandeln.
    if(!isset($data["itineraries"]) || !is_array($data["itineraries"])){
        return [];
    }

    $legs = indexById($data["legs"] ?? []);
    $places = indexById($data["places"] ?? []);
    $carriers = indexById($data["carriers"] ?? []);
    $flightsByKey = [];
    $maxResults = 20;

    foreach($data["itineraries"] as $item){
        $legIds = $item["leg_ids"] ?? [];
        $outboundLeg = isset($legIds[0], $legs[$legIds[0]]) ? $legs[$legIds[0]] : null;
        $returnLeg = isset($legIds[1], $legs[$legIds[1]]) ? $legs[$legIds[1]] : null;

        if(!$outboundLeg){
            continue;
        }

        $price = $item["cheapest_price"]["amount"]
            ?? $item["pricing_options"][0]["price"]["amount"]
            ?? 0;

        $destinationPlaceId = $outboundLeg["destination_place_id"] ?? null;
        $destination = $destinationPlaceId && isset($places[$destinationPlaceId])
            ? formatPlaceName($places[$destinationPlaceId])
            : "Ziel";

        $carrierId = $outboundLeg["marketing_carrier_ids"][0] ?? null;
        $airline = $carrierId !== null && isset($carriers[$carrierId])
            ? ($carriers[$carrierId]["name"] ?? "Airline")
            : "Airline";

        $deepLink = $item["deepLink"]
            ?? $item["deeplink"]
            ?? $item["pricing_options"][0]["items"][0]["url"]
            ?? "";

        $flight = [
            "city" => $destination,
            "price" => (float)$price,
            "priceFormatted" => number_format((float)$price, 2, ",", ".") . " " . $currency,
            "airline" => $airline,
            "duration" => round(($outboundLeg["duration"] ?? 0) / 60, 1),
            "returnDuration" => $returnLeg ? round(($returnLeg["duration"] ?? 0) / 60, 1) : null,
            "stops" => $outboundLeg["stop_count"] ?? 0,
            "returnStops" => $returnLeg["stop_count"] ?? null,
            "departureTime" => $outboundLeg["departure"] ?? "",
            "arrivalTime" => $outboundLeg["arrival"] ?? "",
            "returnDepartureTime" => $returnLeg["departure"] ?? "",
            "returnArrivalTime" => $returnLeg["arrival"] ?? "",
            "bookingUrl" => normalizeBookingUrl($deepLink)
        ];

        // Hier werden doppelte Verbindungen zusammengefasst, damit nicht dieselben Fluege mehrfach erscheinen.
        $uniqueKey = buildFlightUniqueKey($outboundLeg, $returnLeg, $price);

        if(!isset($flightsByKey[$uniqueKey]) || $flight["price"] < $flightsByKey[$uniqueKey]["price"]){
            $flightsByKey[$uniqueKey] = $flight;
        }
    }

    $flights = array_values($flightsByKey);

    usort($flights, fn($a, $b) => $a["price"] <=> $b["price"]);

    return array_slice($flights, 0, $maxResults);
    
}

function buildFlightUniqueKey($outboundLeg, $returnLeg, $price){
    $parts = [
        $outboundLeg["origin_place_id"] ?? "",
        $outboundLeg["destination_place_id"] ?? "",
        $outboundLeg["departure"] ?? "",
        $outboundLeg["arrival"] ?? "",
        $outboundLeg["duration"] ?? "",
        $outboundLeg["stop_count"] ?? 0,
        $returnLeg["origin_place_id"] ?? "",
        $returnLeg["destination_place_id"] ?? "",
        $returnLeg["departure"] ?? "",
        $returnLeg["arrival"] ?? "",
        $returnLeg["duration"] ?? "",
        $returnLeg["stop_count"] ?? 0,
        round((float)$price, 2)
    ];

    return strtolower(implode("|", array_map("strval", $parts)));
}
// KI-Teil Ende

function normalizeBookingUrl($url){
    if(!$url){
        return "";
    }

    if(str_starts_with($url, "http://") || str_starts_with($url, "https://")){
        return $url;
    }

    if(str_starts_with($url, "/")){
        return "https://www.skyscanner.net" . $url;
    }

    return $url;
}

function indexById($items){
    $indexed = [];

    foreach($items as $item){
        if(isset($item["id"])){
            $indexed[(string)$item["id"]] = $item;
        }
    }

    return $indexed;
}

function formatPlaceName($place){
    $name = $place["name"] ?? $place["city_name"] ?? $place["display_code"] ?? "Ziel";
    $code = $place["display_code"] ?? $place["iata"] ?? "";

    if($code && stripos($name, $code) === false){
        return $name . " (" . $code . ")";
    }

    return $name;
}
