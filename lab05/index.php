<?php

declare(strict_types=1);

// Подключаем все необходимые файлы
require_once 'TransactionStorageInterface.php';
require_once 'Transaction.php';
require_once 'TransactionRepository.php';
require_once 'TransactionManager.php';
require_once 'TransactionTableRenderer.php';

// Инициализация
$repository = new TransactionRepository();

// Добавляем тестовые данные
$repository->addTransaction(new Transaction(1, '2023-10-01', 680.50, 'Покупка продуктов', 'Kaufland'));
$repository->addTransaction(new Transaction(2, '2023-10-05', 199.00, 'Ежемесячная подписка', 'Netflix'));
$repository->addTransaction(new Transaction(3, '2023-10-12', 3200.00, 'Оплата авиабилетов', 'Wizzair'));
$repository->addTransaction(new Transaction(4, '2023-11-01', 120.00, 'Обед с одногруппниками', 'KFC'));
$repository->addTransaction(new Transaction(5, '2023-11-15', 8500.00, 'Бронирование отеля', 'Radisson'));
$repository->addTransaction(new Transaction(6, '2023-12-05', 45.00, 'Покупка кофе', 'Scull Coffe'));
$repository->addTransaction(new Transaction(7, '2023-12-20', 17899.00, 'Покупка ноутбука', 'X Store'));
$repository->addTransaction(new Transaction(8, '2024-01-10', 65.00, 'Музыкальная подписка', 'Spotify'));
$repository->addTransaction(new Transaction(9, '2024-02-14', 700.00, 'Ужин в ресторане', 'Mimino'));
$repository->addTransaction(new Transaction(10, '2024-03-01', 150.00, 'Покупка воды и снеков', 'Linella'));

// Создаем менеджер
$manager = new TransactionManager($repository);

// Подготавливаем данные: например, сортируем по дате
$sortedTransactions = $manager->sortTransactionsByDate();

// Выводим таблицу
$renderer = new TransactionTableRenderer();
echo "<h2>Список транзакций</h2>";
echo $renderer->render($sortedTransactions);