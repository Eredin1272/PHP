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
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f6f9;
        display: flex;
        justify-content: center;
        margin-top: 50px;
    }

    .container {
        background: white;
        padding: 25px 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        width: 400px;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
    }

    input, select, textarea {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        margin-bottom: 15px;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    input[type="radio"] {
        width: auto;
        margin-right: 5px;
    }

    .radio-group {
        margin-bottom: 15px;
    }

    button {
        width: 100%;
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background-color: #45a049;
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