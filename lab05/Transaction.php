<?php

declare(strict_types=1);

/**
 * Класс Transaction
 * Описывает сущность одной банковской транзакции.
 */
class Transaction
{
    /**
     * @param int    $id          Уникальный идентификатор транзакции.
     * @param string $date        Дата транзакции (в формате YYYY-MM-DD).
     * @param float  $amount      Сумма транзакции.
     * @param string $description Описание платежа.
     * @param string $merchant    Получатель платежа.
     */
    public function __construct(
        private int $id,
        private string $date,
        private float $amount,
        private string $description,
        private string $merchant
    ) {
    }

    public function getId(): int { return $this->id; }
    public function getDate(): string { return $this->date; }
    public function getAmount(): float { return $this->amount; }
    public function getDescription(): string { return $this->description; }
    public function getMerchant(): string { return $this->merchant; }

    /**
     * Возвращает количество дней с момента транзакции до текущей даты.
     *
     * @return int Количество прошедших дней.
     */
    public function getDaysSinceTransaction(): int
    {
        $transactionDate = new DateTime($this->date);
        $currentDate = new DateTime();
        $interval = $currentDate->diff($transactionDate);
        
        return (int)$interval->format('%a');
    }
}