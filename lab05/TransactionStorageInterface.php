<?php

declare(strict_types=1);

/**
 * Интерфейс TransactionStorageInterface
 * Определяет контракт для хранилища транзакций.
 */
interface TransactionStorageInterface
{
    /**
     * Добавляет новую транзакцию в хранилище.
     *
     * @param Transaction $transaction Объект транзакции.
     * @return void
     */
    public function addTransaction(Transaction $transaction): void;

    /**
     * Удаляет транзакцию по ее идентификатору.
     *
     * @param int $id Идентификатор транзакции.
     * @return void
     */
    public function removeTransactionById(int $id): void;

    /**
     * Возвращает массив всех транзакций.
     *
     * @return Transaction[] Массив транзакций.
     */
    public function getAllTransactions(): array;

    /**
     * Ищет транзакцию по идентификатору.
     *
     * @param int $id Идентификатор транзакции.
     * @return Transaction|null Найденная транзакция или null, если не найдена.
     */
    public function findById(int $id): ?Transaction;
}