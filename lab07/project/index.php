<?php

require_once 'src/functions.php';
require_once 'src/handler.php';
require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates_twig');
$twig = new \Twig\Environment($loader);

$twig->addFilter(new \Twig\TwigFilter('stars', function ($rating) {
    return str_repeat('⭐', $rating);
}));

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

if ($page === 'list') {
    echo $twig->render('list.twig', [
        'games' => $games
    ]);
} else {
    echo $twig->render('form.twig', [
        'errors' => $errors
    ]);
}

