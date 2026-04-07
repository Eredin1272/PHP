<?php
declare(strict_types=1);

$transactions = [
    [
        "id" => 1,
        "date" => "2024-12-12",
        "amount" => 42.35,
        "description" => "Payment for a bottle of beer",
        "merchant" => "Linella",
    ],
    [
        "id" => 2,
        "date" => "2025-03-11",
        "amount" => 27.99,
        "description" => "Payment for a throat lozenges",
        "merchant" => "Felicia",
    ],
];

// ФУНКЦИИ
/**
 * Вычисляет общую сумму всех транзакций.
 *
 * Проходит по массиву транзакций и суммирует значения поля 'amount'.
 *
 * @param array $transactions -  Массив транзакций
 * @return float Общая сумма всех транзакций
 */
function calculateTotalAmount(array $transactions): float
{
    $total = 0.0;

    foreach ($transactions as $transaction) {
        $total += $transaction['amount'];
    }

    return $total;
}

$totalAmount = calculateTotalAmount($transactions);

/**
 * Осуществляет поиск транзакции по части её описания.
 *
 * Возвращает первую найденную транзакцию, в описании которой
 * содержится указанная строка.
 *
 * @param string $descriptionPart -  Часть строки для поиска в описании
 * @param array $transactions - Массив транзакций
 * @return array|null Найденная транзакция или null, если совпадений нет
 */
function findTransactionByDescription(string $descriptionPart, array $transactions): ?array
{
    foreach ($transactions as $transaction) {
        if (strpos($transaction['description'], $descriptionPart) !== false) {
            return $transaction;
        }
    }

    return null;
}

$foundByDescription = findTransactionByDescription("beer", $transactions);


/**
 * Осуществляет поиск транзакции по её идентификатору с использованием цикла foreach.
 *
 * @param int $id - Идентификатор транзакции
 * @param array $transactions - Массив транзакций
 * @return array|null Найденная транзакция или null, если не найдена
 */
function findTransactionByIdForeach(int $id, array $transactions): ?array
{
    foreach ($transactions as $transaction) {
        if ($transaction['id'] === $id) {
            return $transaction;
        }
    }

    return null;
}

$foundByIdForeach = findTransactionByIdForeach(1, $transactions);

/**
 * Осуществляет поиск транзакции по её идентификатору
 * с использованием функции array_filter.
 *
 * @param int $id -  Идентификатор транзакции
 * @param array $transactions - Массив транзакций
 * @return array|null Найденная транзакция или null, если не найдена
 */
function findTransactionByIdArrayFilter(int $id, array $transactions): ?array
{
    $filtered = array_filter($transactions, function ($transaction) use ($id) {
        return $transaction['id'] === $id;
    });

    return !empty($filtered) ? reset($filtered) : null;
}

$foundByIdArrayFilter = findTransactionByIdArrayFilter(2, $transactions);

/**
 * Вычисляет количество дней, прошедших с момента совершения транзакции.
 *
 * Сравнивает переданную дату транзакции с текущей датой
 * и возвращает разницу в днях.
 *
 * @param string $date - Дата транзакции в формате Y-m-d
 * @return int Количество дней с момента транзакции
 */
function daySinceTransaction(string $date): int
{
    $transactionDate = new DateTime($date);
    $today = new DateTime('today');
    $difference = $today->diff($transactionDate);

    return (int)$difference->days;
}

$daysSince = daySinceTransaction("2024-12-12");

/**
 * Добавляет новую транзакцию в глобальный массив $transactions.
 *
 * Функция получает данные транзакции и добавляет их
 * в конец массива транзакций.
 *
 * Используется глобальная переменная $transactions.
 *
 * @param int $id - Идентификатор транзакции
 * @param string $date - Дата транзакции в формате Y-M-D
 * @param float $amount - Сумма транзакции
 * @param string $description - Описание транзакции
 * @param string $merchant - Название продавца 
 * @return void
 */
function addTransaction(
    int $id,
    string $date,
    float $amount,
    string $description,
    string $merchant
): void
{
    global $transactions;

    $newTransaction = [
        "id" => $id,
        "date" => $date,
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant,
    ];

    $transactions[] = $newTransaction;
}

$add = addTransaction(3, "2025-03-01", 3799.89, "New phone", "Darwin");
$totalAmount = calculateTotalAmount($transactions);

/**
 * Сортирует массив транзакций по дате (от старых к новым).
 *
 * Использует функцию usort() и сравнивает даты транзакций
 * с помощью strtotime().
 *
 * @param array &$transactions - Массив транзакций (& - передаётся по ссылке)
 * @return void
 */
function sortTransactionsByDate(array &$transactions): void
{
    usort($transactions, function ($a, $b) {
        return strtotime($a['date']) <=> strtotime($b['date']);
    });
}

$dateSorting = sortTransactionsByDate($transactions);

/**
 * Сортирует массив транзакций по сумме (по убыванию).
 *
 * Транзакции с большей суммой будут располагаться первыми.
 *
 * @param array &$transactions Массив транзакций
 * @return void
 */
function sortTransactionsByAmountDesc(array &$transactions): void
{
    usort($transactions, function ($a, $b) {
        return $b['amount'] <=> $a['amount'];
    });
}

$amountSortingDesc = sortTransactionsByAmountDesc($transactions);

/** 
 * 
 * Удаляет транзакцию из массива транзакций
 * 
 * @param int $id - ID по которому будем удалять транзакцию
 * @return bool - true - если транзакция, false - если не найдена
 */ 

function deleteTransaction(int $id): bool
{
    global $transactions;

    foreach ($transactions as $key => $transaction) {
        if ($transaction['id'] === $id) {
            unset($transactions[$key]);

            $transactions = array_values($transactions);
            return true;
        }
    }

    return false;
}

$delTransaction = deleteTransaction(3);
require 'template.php';
?>


