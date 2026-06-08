# Nature Calls - Projektuebersicht

Nature Calls ist eine PHP/MySQL-Webseite fuer Reiseziele, echte Flug-Suche ueber FlightAPI, Login/Registrierung und einen Warenkorb mit Buchungsfunktion.

## Wichtige Dateien

### Allgemein

- `db.php`  
  Stellt die Verbindung zur MySQL-Datenbank her. Alle SQL-Abfragen laufen ueber das `$pdo`-Objekt.

- `header.php`  
  Enthaelt die Navigation. Wenn ein User eingeloggt ist, werden Username, Warenkorb und Logout angezeigt. Wenn kein User eingeloggt ist, werden Login und Registrierung angezeigt.

- `general.css` und `css/`  
  Enthalten globale Styles und weitere CSS-Dateien fuer einzelne Seiten.

### Login und Registrierung

- `register.php`  
  Erstellt neue User. Das Passwort wird mit `password_hash()` sicher gehasht und dann in der Tabelle `users` gespeichert.

- `login.php`  
  Prueft die Login-Daten. Der User wird ueber die Email gesucht und das Passwort wird mit `password_verify()` geprueft. Bei Erfolg werden `user_id` und `username` in der Session gespeichert.

- `logout.php`  
  Beendet die Session und leitet zurueck zum Login.

### Flug-Suche

- `flight_api.php`  
  Enthaelt die Verbindung zur FlightAPI. Die Funktion `searchFlights()` baut die Roundtrip-URL zusammen, ruft die API per cURL auf und gibt die JSON-Daten als PHP-Array zurueck.  
  Die Funktion `searchFlightsStable()` fragt FlightAPI bei einer neuen Suche zweimal mit kurzer Pause ab und nimmt die Antwort mit den meisten normalisierten Fluegen. Die Funktion `normalizeFlightApiResults()` wandelt die API-Antwort in ein einfacheres Format um, das `results.php` anzeigen kann. Dabei werden doppelte Flugkombinationen mit gleicher Verbindung und gleichem Preis entfernt.

- `flights/flights.php`  
  Zeigt das Suchformular fuer Fluege. Der User waehlt Abflughafen, Hinflugdatum und Rueckflugdatum. Das Ziel-Land wird per `country` in der URL mitgegeben.

- `flights/results.php`  
  Nimmt die Suchdaten entgegen, mappt Laender auf Ziel-Airports und ruft `searchFlightsStable()` auf. Danach werden die Ergebnisse angezeigt und koennen nach Preis sortiert werden. Die erste fertige Suche wird in der Session zwischengespeichert, damit Reload und Sortieren keine neue FlightAPI-Anfrage ausloesen. Jeder Flug hat einen Button `In Warenkorb`.

- `flights/css/results.css`  
  Styling fuer die Ergebnis-Seite.

### Warenkorb und Buchungen

- `flights/add_to_cart.php`  
  Speichert einen ausgewaehlten Flug in der Datenbank. Die Datei prueft zuerst, ob der User eingeloggt ist. Danach werden Land, Flug und Warenkorb-Eintrag gespeichert.  
  Verwendete Tabellen: `countries`, `flights`, `cart`.

- `flights/cart.php`  
  Zeigt den Warenkorb des eingeloggten Users. Die Seite nutzt mehrere SQL-Abfragen:
  - `INNER JOIN`, um Warenkorb, Fluege und Laender zusammen anzuzeigen
  - `SUM`, um den Gesamtpreis zu berechnen
  - `COUNT`, um die Anzahl der Fluege zu berechnen
  - `DELETE`, um einzelne Fluege oder den ganzen Warenkorb zu loeschen
  - `INSERT`, um beim Checkout Eintraege in `bookings` zu speichern

- `flights/css/cart.css`  
  Styling fuer Warenkorb, Zusammenfassung und letzte Buchungen.

## Datenbankstruktur

Die Seite ist auf diese Tabellen ausgelegt:

```sql
USERS
id
username
email
password

COUNTRIES
id
name

FLIGHTS
id
country_id
departure_city
arrival_city
price
departure_date
return_date

CART
id
user_id
flight_id

BOOKINGS
id
user_id
flight_id
booking_date
```

## Ablauf: Flug suchen

1. Der User oeffnet ein Reiseziel und kommt zu `flights/flights.php`.
2. Im Formular waehlt der User Abflugort, Hinflugdatum und Rueckflugdatum.
3. Das Formular sendet per `GET` an `flights/results.php`.
4. `results.php` wandelt das Land in einen IATA-Code um, zum Beispiel:
   - `china` -> `PEK`
   - `japan` -> `HND`
   - `italien` -> `FCO`
   - `schweiz` -> `ZRH`
   - `neuseeland` -> `AKL`
   - `mongolei` -> `UBN`
5. `results.php` ruft `searchFlightsStable()` aus `flight_api.php` auf.
6. `flight_api.php` ruft die FlightAPI Roundtrip-API zweimal mit kurzer Pause auf und nimmt die Antwort mit den meisten Fluegen.
7. `normalizeFlightApiResults()` macht aus der API-Antwort einfache Flugkarten fuer die Webseite.
8. Doppelte Flugkombinationen werden entfernt.
9. Die Results-Seite zeigt Preis, Airline, Dauer, Stops, Startzeit und Ankunftszeit.
10. Beim Reload und Sortieren werden die gespeicherten Session-Ergebnisse genutzt, statt FlightAPI erneut aufzurufen.

## Ablauf: Flug in den Warenkorb legen

1. Der User klickt auf `In Warenkorb`.
2. `results.php` sendet die wichtigsten Flugdaten per `POST` an `flights/add_to_cart.php`.
3. `add_to_cart.php` prueft, ob der User eingeloggt ist.
4. Das Land wird in `countries` gesucht oder neu gespeichert.
5. Der Flug wird in `flights` gesucht oder neu gespeichert.
6. Danach wird die Verbindung aus User und Flug in `cart` gespeichert.
7. Der User wird zu `flights/cart.php` weitergeleitet.

## Ablauf: Warenkorb und Buchung

1. `cart.php` liest alle Warenkorb-Eintraege des eingeloggten Users aus.
2. Per SQL-Join werden passende Flug- und Laender-Daten geladen.
3. Der Gesamtpreis wird mit `SUM(flights.price)` berechnet.
4. Die Anzahl der Warenkorb-Eintraege wird mit `COUNT(*)` berechnet.
5. Der User kann einzelne Fluege entfernen oder den ganzen Warenkorb leeren.
6. Bei `Buchung speichern` werden alle Warenkorb-Fluege in `bookings` eingetragen.
7. Danach wird der Warenkorb geleert.
8. Die letzten 5 Buchungen werden unten angezeigt.

## API-Key wechseln

Der FlightAPI-Key steht aktuell in `flight_api.php`:

```php
const FLIGHT_API_KEY = "DEIN_KEY_HIER";
```

Wenn keine Credits mehr uebrig sind, funktioniert die Webseite technisch wieder, sobald dort ein neuer gueltiger FlightAPI-Key eingetragen wird. Wichtig: Nutze Accounts und Credits so, wie es die Regeln von FlightAPI erlauben. Wenn die Plattform Mehrfach-Accounts zum Umgehen von Limits verbietet, solltest du das nicht machen. Sauberer waere dann ein Upgrade, neue Credits oder ein anderer erlaubter API-Key.

## Lokale Nutzung mit Laragon

1. Laragon starten.
2. MySQL-Datenbank `nature_calls` anlegen.
3. Tabellen nach der oben genannten Struktur erstellen.
4. In `db.php` pruefen, ob Datenbankname, User und Passwort stimmen.
5. In `flight_api.php` einen gueltigen FlightAPI-Key eintragen.
6. Projekt im Browser oeffnen:

```text
http://localhost/nature/
```

## Hinweise

- Der echte API-Key sollte nicht oeffentlich auf GitHub landen.
- Fuer GitHub besser eine Config-Datei oder `.env` benutzen und den echten Key ignorieren.
- Die aktuelle Flug-Suche nutzt Economy, 1 Erwachsenen, 0 Kinder, 0 Babys und EUR.
- Eine neue Suche nutzt aktuell 2 FlightAPI-Anfragen, weil die zweite Antwort manchmal mehr Ergebnisse enthaelt.
- Die gespeicherten Fluege im Warenkorb sind Momentaufnahmen der Suchergebnisse. Preise koennen sich bei der echten Airline/API spaeter aendern.
