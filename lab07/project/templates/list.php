<h2>Список игр</h2>

<table class="game-table">
<tr>
<th><a href="?page=list&sort=title">Название</a></th>
<th>Жанр</th>
<th>Платформа</th>
<th><a href="?page=list&sort=rating">Оценка</a></th>
<th>Часы</th>
<th><a href="?page=list&sort=completed_at">Дата</a></th>
<th>Отзыв</th>
</tr>

<?php foreach ($games as $game): ?>
<tr>
<td><?= $game['title'] ?></td>
<td><?= $game['genre'] ?></td>
<td><?= $game['platform'] ?></td>
<td><?= $game['rating'] ?></td>
<td><?= $game['play_time'] ?></td>
<td><?= $game['completed_at'] ?></td>
<td class="review"><?= $game['review'] ?></td>
</tr>
<?php endforeach; ?>

</table>