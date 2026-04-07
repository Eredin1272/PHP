<!DOCTYPE html>
<html lang="ru">
<head>
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
    <meta charset="UTF-8">
    <title>Каталог игр</title>
</head>
<body>


<form action="process.php" method="POST">
<h2>Добавить игру</h2>

<label>Название игры:</label><br>
<input type="text" name="title" required minlength="2"><br><br>

<label>Жанр:</label><br>
<select name="genre" required>
    <option value="">Выберите жанр</option>
    <option value="RPG">RPG</option>
    <option value="Shooter">Shooter</option>
    <option value="Strategy">Strategy</option>
    <option value="Horror">Horror</option>
    <option value="Adventure">Adventure</option>
</select><br><br>

<label>Платформа:</label><br>
<input type="text" name="platform" required><br><br>

<label>Оценка:</label><br>
<input type="radio" name="rating" value="1" required>1
<input type="radio" name="rating" value="2">2
<input type="radio" name="rating" value="3">3
<input type="radio" name="rating" value="4">4
<input type="radio" name="rating" value="5">5
<br><br>

<label>Время прохождения (часы):</label><br>
<input type="number" name="play_time" required min="1"><br><br>

<label>Дата прохождения:</label><br>
<input type="date" name="completed_at" required><br><br>

<label>Отзыв:</label><br>
<textarea name="review" required minlength="10"></textarea><br><br>

<button type="submit">Сохранить</button>

<a href="view.php" class="view-btn">📋 Посмотреть список игр</a>

</form>

</body>
</html>