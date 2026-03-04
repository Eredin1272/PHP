<?php
declare(strict_types=1);

$transactions = [
    [
        "id" => 1,
        "date" => "2024-12-12",
        "amount" => 42.00,
        "description" => "Payment for a bottle of beer",
        "merchant" => "Linella",
    ],
    [
        "id" => 2,
        "date" => "2025-03-11",
        "amount" => 27.00,
        "description" => "Payment for a throat lozenges",
        "merchant" => "Felicia",
    ],
];



// Функции
// Общая сумма

function calculateTotalAmont(array $transactions): float
{
    $total = 0.0;
    foreach ($transactions as $transaction) {
        $total += $transaction['amount'];
    }
    return $total;
}

// Поиск транзакции по части описания

function findTransactionByDescription(string $descriptionPart, array $transactions): ?array
{
    foreach ($transactions as $transaction) {
        if (strpos($transactions['description'], $descriptionPart) !== false){
            return $transaction;
        }
    }
    return null;
}

// Поиск транзакции по ID
// foreach
function findTransactionByIdForecah(int $id, array $transactions): ?array
{
    foreach ($transactions as $transaction) {
        if($transaction['id'] === $id) {
            return $transaction;
        }
    }
    return null;
}

//array_filter
function findTransactionByIdArrayFilter(int $id, array $transactions): ?array
{
    $filtered = array_filter($transactions, function($transaction) use ($id) {
        return $transaction['id'] === $id;
    });
    return !empty($filtered) ? reset($filtered) : null;
}

// Количество дней с момента транзакции
function daySinceTransaction(string $date): int
{
    $transactionDate = new DateTime($date);
    $today = new DateTime('today');
    $difference = $today->diff($transactionDate);
    return (int)$difference->days;
}


?>




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
</table>
</body>
</html>