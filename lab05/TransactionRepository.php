<?php

declare(strict_types=1);

/**
 * Класс TransactionRepository
 * Отвечает за хранение массива транзакций и базовые операции доступа к ним.
 */
class TransactionRepository implements TransactionStorageInterface
{
    /**
     * @var Transaction[] Массив транзакций.
     */
    private array $transactions = [];

    public function addTransaction(Transaction $transaction): void
    {
        $this->transactions[] = $transaction;
    }

    public function removeTransactionById(int $id): void
    {
        foreach ($this->transactions as $index => $transaction) {
            if ($transaction->getId() === $id) {
                unset($this->transactions[$index]);
                $this->transactions = array_values($this->transactions); // Переиндексация
                break;
            }
        }
    }

    public function getAllTransactions(): array
    {
        return $this->transactions;
    }

    public function findById(int $id): ?Transaction
    {
        foreach ($this->transactions as $transaction) {
            if ($transaction->getId() === $id) {
                return $transaction;
            }
        }
        return null;
    }
}