<h2>Добавить игру</h2>

<form action="process.php" method="POST">

    <label>Название игры:</label><br>
    <input type="text" name="title"><br><br>

    <label>Жанр:</label><br>
    <select name="genre">
        <option value="">Выберите жанр</option>
        <option value="RPG">RPG</option>
        <option value="Shooter">Shooter</option>
    </select><br><br>

    <label>Платформа:</label><br>
    <input type="text" name="platform"><br><br>

    <label>Оценка:</label><br>
    <input type="radio" name="rating" value="1">1
    <input type="radio" name="rating" value="2">2
    <input type="radio" name="rating" value="3">3
    <input type="radio" name="rating" value="4">4
    <input type="radio" name="rating" value="5">5

    <br><br>

    <button type="submit">Сохранить</button>
</form>