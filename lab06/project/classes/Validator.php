<?php

/**
 * Класс для валидации данных формы
 */
class Validator
{
    private array $errors = [];

    /**
     * Проверка обязательного поля
     */
    public function required(string $field, $value, string $message)
    {
        if (empty($value)) {
            $this->errors[$field] = $message;
        }
    }

    /**
     * Проверка минимальной длины строки
     */
    public function minLength(string $field, string $value, int $length, string $message)
    {
        if (strlen($value) < $length) {
            $this->errors[$field] = $message;
        }
    }

    /**
     * Проверка числа
     */
    public function isNumber(string $field, $value, string $message)
    {
        if (!is_numeric($value)) {
            $this->errors[$field] = $message;
        }
    }

    /**
     * Проверка даты
     */
    public function isDate(string $field, $value, string $message)
    {
        if (!strtotime($value)) {
            $this->errors[$field] = $message;
        }
    }

    /**
     * Получить ошибки
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Есть ли ошибки
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }
}