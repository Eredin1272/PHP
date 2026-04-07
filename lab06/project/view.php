<?php

$data = [];

if (file_exists('data.txt')) {
    $json = file_get_contents('data.txt');
    $data = json_decode($json, true) ?? [];
}

$sort = $_GET['sort'] ?? '';

if ($sort) {
    usort($data, function ($a, $b) use ($sort) {
        return $a[$sort] <=> $b[$sort];
    });
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список игр</title>

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #ddd;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>
<body>

<h2>Список пройденных игр</h2>

<a href="index.php">Добавить новую игру</a><br><br>

<table>
    <tr>
        <th><a href="?sort=title">Название</a></th>
        <th><a href="?sort=genre">Жанр</a></th>
        <th><a href="?sort=platform">Платформа</a></th>
        <th><a href="?sort=rating">Оценка</a></th>
        <th><a href="?sort=play_time">Часы</a></th>
        <th><a href="?sort=completed_at">Дата прохождения</a></th>
        <th>Отзыв</th>
        <th><a href="?sort=created_at">Добавлено</a></th>
    </tr>

    <?php if (!empty($data)): ?>
        <?php foreach ($data as $game): ?>
            <tr>
                <td><?= $game['title'] ?></td>
                <td><?= $game['genre'] ?></td>
                <td><?= $game['platform'] ?></td>
                <td><?= $game['rating'] ?></td>
                <td><?= $game['play_time'] ?></td>
                <td><?= $game['completed_at'] ?></td>
                <td><?= $game['review'] ?></td>
                <td><?= $game['created_at'] ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8">Нет данных</td>
        </tr>
    <?php endif; ?>

</table>

</body>
</html>