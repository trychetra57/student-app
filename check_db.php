<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306', 'root', '');
    echo "Connected to MySQL\n";
    $databases = $pdo->query('SHOW DATABASES')->fetchAll(PDO::FETCH_ASSOC);
    print_r($databases);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
