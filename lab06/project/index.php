<?php

require_once 'src/functions.php';
require_once 'src/handler.php';

$action = $_GET['action'] ?? 'form';

if ($action === 'add' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = handleForm();

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }

    header("Location: index.php?action=list");
    exit;
}

if ($action === 'list') {
    $games = getGames();

    if (isset($_GET['sort'])) {
        $games = sortGames($games, $_GET['sort']);
    }

    $content = 'templates/list.php';
} else {
    $content = 'templates/form.php';
}

include 'templates/layout.php';