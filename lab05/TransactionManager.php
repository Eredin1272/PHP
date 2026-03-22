<?php

declare(strict_types=1);

/**
 * Класс TransactionManager
 * Содержит бизнес-логику для работы с коллекцией транзакций.
 */
class TransactionManager
{
    public function __construct(
        private TransactionStorageInterface $repository
    ) {
    }

    public function calculateTotalAmount(): float
    {
        $total = 0.0;
        foreach ($this->repository->getAllTransactions() as $transaction) {
            $total += $transaction->getAmount();
        }
        return $total;
    }

    public function calculateTotalAmountByDateRange(string $startDate, string $endDate): float
    {
        $total = 0.0;
        $start = strtotime($startDate);
        $end = strtotime($endDate);

        foreach ($this->repository->getAllTransactions() as $transaction) {
            $txDate = strtotime($transaction->getDate());
            if ($txDate >= $start && $txDate <= $end) {
                $total += $transaction->getAmount();
            }
        }
        return $total;
    }

    public function countTransactionsByMerchant(string $merchant): int
    {
        $count = 0;
        foreach ($this->repository->getAllTransactions() as $transaction) {
            if (strcasecmp($transaction->getMerchant(), $merchant) === 0) {
                $count++;
            }
        }
        return $count;
    }

    public function sortTransactionsByDate(): array
    {
        $transactions = $this->repository->getAllTransactions();
        usort($transactions, function (Transaction $a, Transaction $b) {
            return strtotime($a->getDate()) <=> strtotime($b->getDate());
        });
        return $transactions;
    }

    public function sortTransactionsByAmountDesc(): array
    {
        $transactions = $this->repository->getAllTransactions();
        usort($transactions, function (Transaction $a, Transaction $b) {
            return $b->getAmount() <=> $a->getAmount();
        });
        return $transactions;
    }
}