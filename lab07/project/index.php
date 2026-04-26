<?php

require_once 'src/functions.php';
require_once 'src/handler.php';

$page = $_GET['page'] ?? 'form';
$sort = $_GET['sort'] ?? '';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = handleForm();
}

$games = getGames();

if ($sort) {
    usort($games, fn($a, $b) => $a[$sort] <=> $b[$sort]);
}

ob_start();

if ($page === 'list') {
    include 'templates/list.php';
} else {
    include 'templates/form.php';
}

$content = ob_get_clean();

include 'templates/layout.php';