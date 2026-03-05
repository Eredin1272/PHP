<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список транзакций</title>
    <style>
        table {
            margin: 0 auto; 
            border-collapse: collapse; 
        }
        th, td {
            padding: 8px; 
            text-align: left; 
        }
    </style>
</head>
<body>

<table border='1'>
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Description</th>
            <th>Merchant</th>
        </tr>   
    </thead>

    <tbody>
        <?php foreach ($transactions as $transactions): ?>
            <tr>
                <td><?= $transactions['id'] ?></td>
                <td><?= $transactions['date'] ?></td>
                <td><?= $transactions['amount'] ?></td>
                <td><?= $transactions['description'] ?></td>
                <td><?= $transactions['merchant'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
   <tr>
        <td colspan="2"><strong>Total</strong></td>
        <td><strong><?= $totalAmount ?></strong></td>
        <td colspan="2"></td>
    </tr>
</table>

<h1> Использование функций</h1>
    <h3>Поиск по описанию ("beer"):</h3>
<?php 
if ($foundByDescription) {
    echo "{$foundByDescription['description']} ({$foundByDescription['amount']})";
} else {
    echo "Нет результатов";
}
?>

    <h3><br/>Поиск по ID (foreach):</h3>
<?php
if ($foundByIdForeach) {
    echo "{$foundByIdForeach['id']} - ({$foundByIdForeach['description']})";
} else {
    echo "Нет результатов";
}
?>
    <h3><br/>Поиск по ID (array_filter):</h3>
<?php
    if ($foundByIdArrayFilter) {
        echo"{$foundByIdArrayFilter['id']} - ({$foundByIdArrayFilter['description']})";
    } else {
        echo "Нет Результатов";
    }
?>
    <h3><br/>Дней с момента транзакции 2024-12-12:</h3>
            <p><?= $daysSince ?> дней</p>
</body>
</html>
