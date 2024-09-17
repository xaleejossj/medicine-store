<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=medicine_store', 'username', 'password');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}
?>
