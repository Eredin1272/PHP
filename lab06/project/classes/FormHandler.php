<?php

require_once 'Validator.php';
require_once 'Storage.php';

/**
 * Класс обработки формы
 */
class FormHandler
{
    private Validator $validator;
    private Storage $storage;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->storage = new Storage('data.txt');
    }

    /**
     * Обработка формы
     */
    public function handle(array $data): array
    {
        // Валидация
        $this->validator->required('title', $data['title'], 'Введите название');
        $this->validator->minLength('title', $data['title'], 2, 'Минимум 2 символа');

        $this->validator->required('genre', $data['genre'], 'Выберите жанр');

        $this->validator->required('platform', $data['platform'], 'Введите платформу');

        $this->validator->required('rating', $data['rating'], 'Выберите оценку');

        $this->validator->required('play_time', $data['play_time'], 'Введите время');
        $this->validator->isNumber('play_time', $data['play_time'], 'Должно быть числом');

        $this->validator->required('completed_at', $data['completed_at'], 'Выберите дату');
        $this->validator->isDate('completed_at', $data['completed_at'], 'Неверная дата');

        $this->validator->required('review', $data['review'], 'Введите отзыв');

        if ($this->validator->hasErrors()) {
            return $this->validator->getErrors();
        }

        // Подготовка данных
        $game = [
            'title' => htmlspecialchars($data['title']),
            'genre' => htmlspecialchars($data['genre']),
            'platform' => htmlspecialchars($data['platform']),
            'rating' => (int)$data['rating'],
            'play_time' => (int)$data['play_time'],
            'completed_at' => $data['completed_at'],
            'review' => htmlspecialchars($data['review']),
            'created_at' => date('Y-m-d')
        ];

        // Сохранение
        $this->storage->save($game);

        return [];
    }
}