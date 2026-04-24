<h2>Список игр</h2>

<table>
    <tr>
        <th><a href="?sort=title">Название</a></th>
        <th><a href="?sort=genre">Жанр</a></th>
        <th>Платформа</th>
        <th>Оценка</th>
    </tr>

    <?php foreach ($data as $game): ?>
        <tr>
            <td><?= $game['title'] ?></td>
            <td><?= $game['genre'] ?></td>
            <td><?= $game['platform'] ?></td>
            <td><?= $game['rating'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>