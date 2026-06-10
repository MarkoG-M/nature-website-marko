-- ZUSAMMENSTELLUNG VON ALLEN SQL QUERIES AUS DEM PROJEKT "nature"
-- Quelle: C:\laragon\www\nature

/* 1. login.php - User-Daten anhand der eingegebenen E-Mail holen */
SELECT *
FROM users
WHERE email = ?;

/* 2. register.php - Neuen User registrieren */
INSERT INTO users (username, email, password)
VALUES (?, ?, ?);

/* 3. profile.php - Aktuelle Profildaten des eingeloggten Users holen */
SELECT id, username, email
FROM users
WHERE id = ?;

/* 4. profile.php - Pruefen, ob die neue E-Mail schon von einem anderen User benutzt wird */
SELECT id
FROM users
WHERE email = ?
  AND id != ?
LIMIT 1;

/* 5. profile.php - Username und E-Mail des Users aktualisieren */
UPDATE users
SET username = ?, email = ?
WHERE id = ?;

/* 6. flights/add_to_cart.php - Land anhand des Namens suchen, Gross-/Kleinschreibung ignorieren */
SELECT id
FROM countries
WHERE LOWER(name) = LOWER(?)
LIMIT 1;

/* 7. flights/add_to_cart.php - Neues Land einfuegen, falls es noch nicht existiert */
INSERT INTO countries (name)
VALUES (?);

/* 8. flights/add_to_cart.php - Pruefen, ob dieser Flug schon existiert */
SELECT id
FROM flights
WHERE country_id = ?
  AND departure_city = ?
  AND arrival_city = ?
  AND price = ?
  AND departure_date = ?
  AND return_date = ?
LIMIT 1;

/* 9. flights/add_to_cart.php - Neuen Flug einfuegen, falls er noch nicht existiert */
INSERT INTO flights (country_id, departure_city, arrival_city, price, departure_date, return_date)
VALUES (?, ?, ?, ?, ?, ?);

/* 10. flights/add_to_cart.php - Pruefen, ob der Flug bereits im Warenkorb des Users liegt */
SELECT id
FROM cart
WHERE user_id = ?
  AND flight_id = ?
LIMIT 1;

/* 11. flights/add_to_cart.php - Flug in den Warenkorb einfuegen */
INSERT INTO cart (user_id, flight_id)
VALUES (?, ?);

/* 12. flights/cart.php - Einzelnen Flug aus dem Warenkorb entfernen */
DELETE FROM cart
WHERE id = ?
  AND user_id = ?;

/* 13. flights/cart.php - Gesamten Warenkorb eines Users leeren */
DELETE FROM cart
WHERE user_id = ?;

/* 14. flights/cart.php - Alle Flug-IDs aus dem Warenkorb fuer den Checkout holen */
SELECT flight_id
FROM cart
WHERE user_id = ?;

/* 15. flights/cart.php - Buchung fuer einen Flug speichern */
INSERT INTO bookings (user_id, flight_id, booking_date)
VALUES (?, ?, NOW());

/* 16. flights/cart.php - Warenkorb nach erfolgreichem Checkout leeren */
DELETE FROM cart
WHERE user_id = ?;

/* 17. flights/cart.php - Warenkorb-Items mit Flug- und Laenderdaten anzeigen */
SELECT cart.id AS cart_id,
       flights.id AS flight_id,
       countries.name AS country_name,
       flights.departure_city,
       flights.arrival_city,
       flights.price,
       flights.departure_date,
       flights.return_date
FROM cart
INNER JOIN flights ON cart.flight_id = flights.id
INNER JOIN countries ON flights.country_id = countries.id
WHERE cart.user_id = ?
ORDER BY cart.id DESC;

/* 18. flights/cart.php - Gesamtpreis aller Fluege im Warenkorb berechnen */
SELECT COALESCE(SUM(flights.price), 0)
FROM cart
INNER JOIN flights ON cart.flight_id = flights.id
WHERE cart.user_id = ?;

/* 19. flights/cart.php - Anzahl der Fluege im Warenkorb zaehlen */
SELECT COUNT(*)
FROM cart
WHERE user_id = ?;

/* 20. flights/cart.php - Letzte Buchungen des Users anzeigen */
SELECT bookings.id,
       bookings.booking_date,
       countries.name AS country_name,
       flights.departure_city,
       flights.arrival_city,
       flights.price,
       flights.departure_date,
       flights.return_date
FROM bookings
INNER JOIN flights ON bookings.flight_id = flights.id
INNER JOIN countries ON flights.country_id = countries.id
WHERE bookings.user_id = ?
ORDER BY bookings.booking_date DESC
LIMIT 5;
