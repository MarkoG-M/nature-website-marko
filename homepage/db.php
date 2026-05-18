<?php

$pdo = new PDO(
    "mysql:host=localhost;dbname=todo_db;charset=utf8",
    "root",
    "darkdeath",
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]
);