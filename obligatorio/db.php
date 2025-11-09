<?php
try {
    $dwes = new PDO('mysql:host=localhost;dbname=Obligatoria;charset=utf8', 'root', '');
    $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
