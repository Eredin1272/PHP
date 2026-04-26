<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Каталог игр</title>

    <style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f9;
    margin: 0;
    padding: 20px;
}

.container {
    max-width: 900px;
    margin: auto;
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* Навигация */
.nav {
    margin-bottom: 15px;
}

.nav a {
    margin-right: 10px;
    padding: 8px 12px;
    background: #2196F3;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}

.nav a:hover {
    background: #1976D2;
}

/* Форма */
input, select, textarea {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    margin-bottom: 12px;
    border-radius: 5px;
    border: 1px solid #ccc;
}

button {
    padding: 10px;
    background: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background: #45a049;
}

/* Таблица */
.game-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

.game-table th, .game-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
}

.game-table th {
    background: #f0f0f0;
}

.game-table tr:nth-child(even) {
    background: #fafafa;
}

.game-table tr:hover {
    background: #f1f7ff;
}

/* Отзыв */
.review {
    text-align: left;
    max-width: 250px;
    word-wrap: break-word;
}
</style>
</head>
<body>

<div class="container">

    <a href="?page=form">Добавить</a>
    <a href="?page=list">Список</a>

    <hr>

    <?= $content ?>

</div>

</body>
</html>