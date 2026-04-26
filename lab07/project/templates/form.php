<h2>Добавить игру</h2>

<?php foreach ($errors as $error): ?>
    <p style="color:red;"><?= $error ?></p>
<?php endforeach; ?>

<form method="POST">

<input name="title" placeholder="Название" required><br><br>

<select name="genre" required>
    <option value="">Жанр</option>
    <option>RPG</option>
    <option>Shooter</option>
    <option>Strategy</option>
</select><br><br>

<input name="platform" placeholder="Платформа" required><br><br>

Оценка:
<input type="radio" name="rating" value="1" required>1
<input type="radio" name="rating" value="2">2
<input type="radio" name="rating" value="3">3
<input type="radio" name="rating" value="4">4
<input type="radio" name="rating" value="5">5
<br><br>

<input type="number" name="play_time" placeholder="Часы" required><br><br>

<input type="date" name="completed_at" required><br><br>

<textarea name="review" placeholder="Отзыв" required minlength="10"></textarea><br><br>

<button>Сохранить</button>

</form>