<?php

require_once 'functions.php';

function handleForm(): array
{
    $errors = [];

    $title = $_POST['title'] ?? '';
    $genre = $_POST['genre'] ?? '';
    $platform = $_POST['platform'] ?? '';
    $rating = $_POST['rating'] ?? '';
    $play_time = $_POST['play_time'] ?? '';
    $completed_at = $_POST['completed_at'] ?? '';
    $review = $_POST['review'] ?? '';

    // Валидация
    if (empty($title)) $errors[] = "Введите название";
    if (empty($genre)) $errors[] = "Выберите жанр";
    if (empty($platform)) $errors[] = "Введите платформу";
    if (empty($rating)) $errors[] = "Выберите оценку";
    if (!is_numeric($play_time)) $errors[] = "Время должно быть числом";
    // Проверка даты
if (empty($completed_at)) {
    $errors[] = "Выберите дату";
} else {
    $date = DateTime::createFromFormat('Y-m-d', $completed_at);
    if (!$date || $date->format('Y-m-d') !== $completed_at) {
        $errors[] = "Некорректный формат даты";
    }
}
    if (strlen($review) < 10) $errors[] = "Отзыв минимум 10 символов";

    if (!empty($errors)) {
        return $errors;
    }

    $game = [
        'title' => htmlspecialchars($title),
        'genre' => htmlspecialchars($genre),
        'platform' => htmlspecialchars($platform),
        'rating' => (int)$rating,
        'play_time' => (int)$play_time,
        'completed_at' => $completed_at,
        'review' => htmlspecialchars($review),
        'created_at' => date('Y-m-d')
    ];

    saveGame($game);

    return [];
}