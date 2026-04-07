<?php

require_once 'classes/FormHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $handler = new FormHandler();
    $errors = $handler->handle($_POST);

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
        echo "<a href='index.php'>Назад</a>";
        exit;
    }

    header("Location: view.php");
    exit;
}