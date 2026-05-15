<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=student_app', 'root', '');
    echo "Connected to MySQL database student_app\n";
    $tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_ASSOC);
    print_r($tables);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
