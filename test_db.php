<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=spice_basket', 'root', '');
    echo "Connected successfully to spice_basket at 127.0.0.1:3306";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
