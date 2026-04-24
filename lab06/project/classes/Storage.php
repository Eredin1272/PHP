<?php

/**
 * Класс для работы с файлом
 */
class Storage
{
    private string $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     * Сохранение записи в файл (JSON)
     */
    public function save(array $data): void
    {
        $existingData = [];

        if (file_exists($this->file)) {
            $json = file_get_contents($this->file);
            $existingData = json_decode($json, true) ?? [];
        }

        $existingData[] = $data;

        file_put_contents($this->file, json_encode($existingData, JSON_PRETTY_PRINT));
    }
}