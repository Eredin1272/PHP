<?php

declare(strict_types=1);

/**
 * Класс TransactionTableRenderer
 * Отвечает за рендеринг массива транзакций в виде HTML-таблицы.
 */
final class TransactionTableRenderer
{
    /**
     * Генерирует HTML-код таблицы.
     *
     * @param Transaction[] $transactions
     * @return string
     */
    public function render(array $transactions): string
    {
        $html = '<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%; font-family: sans-serif;">';
        $html .= '<thead style="background-color: #f4f4f4;"><tr>';
        $html .= '<th>ID</th><th>Дата</th><th>Сумма</th><th>Описание</th><th>Получатель</th><th>Категория</th><th>Дней назад</th>';
        $html .= '</tr></thead><tbody>';

        foreach ($transactions as $transaction) {
            $category = $this->determineCategory($transaction->getMerchant());
            
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars((string)$transaction->getId()) . '</td>';
            $html .= '<td>' . htmlspecialchars($transaction->getDate()) . '</td>';
            $html .= '<td>' . htmlspecialchars(number_format($transaction->getAmount(), 2, '.', '')) . '</td>';
            $html .= '<td>' . htmlspecialchars($transaction->getDescription()) . '</td>';
            $html .= '<td>' . htmlspecialchars($transaction->getMerchant()) . '</td>';
            $html .= '<td>' . htmlspecialchars($category) . '</td>';
            $html .= '<td>' . htmlspecialchars((string)$transaction->getDaysSinceTransaction()) . '</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';
        return $html;
    }

    private function determineCategory(string $merchant): string
    {
        $merchantLower = strtolower($merchant);
        if (str_contains($merchantLower, 'market') || str_contains($merchantLower, 'grocery')) return 'Супермаркеты';
        if (str_contains($merchantLower, 'netflix') || str_contains($merchantLower, 'spotify')) return 'Подписки';
        if (str_contains($merchantLower, 'restaurant') || str_contains($merchantLower, 'cafe') || str_contains($merchantLower, 'kfc')) return 'Рестораны и Кафе';
        if (str_contains($merchantLower, 'airline') || str_contains($merchantLower, 'hotel')) return 'Путешествия';
        
        return 'Другое';
    }
}