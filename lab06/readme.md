# Лабораторная работа №6. Обработка и валидация форм
### Дисциплина : *PHP*
### Выполнил студент : *Бритков Егор*
### Группа : *I2402*

## Цель работы :

Освоить основные принципы работы с HTML-формами в PHP, включая отправку данных на сервер и их обработку, включая валидацию данных.

## Условие

Необходимо выбрать тему проекта для лабораторной работы, которая будет развиваться на протяжении курса.

## Ход Работы

Мною была выбрана тема *"Мини-каталог пройденных игр"*

---

### Определение модели данных

Для своего проекта буду использовать 8 полей записи:

- title(string),
- genre(enum),
- platform(string),
- rating(enum),
- play_time(number),
- completed_at(date),
- review(text),
- created_at(date)

В форме всё будет происходит следующим образом:

Пользователь вводит:

    Название игры -> Выбирает жанр -> Записывает платформу -> Ставит оценку -> Вводит количество наигранных часов -> Выбирает дату окончания прохождения -> Отзыв

Структура проекта выглядит подобным образом

```
/project
|
|-- index.php      -> форма
|-- process.php    -> обработка
|-- data.txt       -> хранение (JSON)
|-- view.php       -> вывод таблицы
|
|-- classes/
|   |-- Game.php
|   |-- Validator.php
|   |-- Storage.php
|   |-- FormHandler.php
```

---

### HTML-форма

Следующим шагом станет создание HTML-формы.

#### Базоваая структура HTML

```php
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Каталог игр</title>
</head>
<body>

<h2>Добавить игру</h2>

<form action="process.php" method="POST">
```
`action="process.php"` → куда отправляются данные
`method="POST"` -> данные передаются безопаснее (не в URL)

#### Поле: Название игры

```html
<label>Название игры:</label><br>
<input type="text" name="title" required minlength="2"><br><br>
```
`required` -> обязательно заполнить
`minlength="2"` -> минимум 2 символа

#### Жанр (ENUM)

```html
<label>Жанр:</label><br>
<select name="genre" required>
    <option value="">Выберите жанр</option>
    <option value="RPG">RPG</option>
    <option value="Shooter">Shooter</option>
    <option value="Strategy">Strategy</option>
    <option value="Horror">Horror</option>
    <option value="Adventure">Adventure</option>
</select><br><br>
```

`select` -> ограниченный набор значений (это и есть enum)

#### Платформа

```html
<label>Платформа:</label><br>
<input type="text" name="platform" required><br><br>
```

#### Оценка

```html
<label>Оценка:</label><br>
<input type="radio" name="rating" value="1" required>1
<input type="radio" name="rating" value="2">2
<input type="radio" name="rating" value="3">3
<input type="radio" name="rating" value="4">4
<input type="radio" name="rating" value="5">5
<br><br>
```

`radio` -> можно выбрать только один вариант

#### Время прохождения

```html
<label>Время прохождения (часы):</label><br>
<input type="number" name="play_time" required min="1"><br><br>
```

#### Дата прохождения 

```html
<label>Дата прохождения:</label><br>
<input type="date" name="completed_at" required><br><br>
```

#### Отзыв

```html
<label>Отзыв:</label><br>
<textarea name="review" required minlength="10"></textarea><br><br>
```

#### Кнопка отправки

```html
<button type="submit">Сохранить</button>
</form>

</body>
</html>
```

Я создал HTML-форму, которая отправляет данные методом POST в PHP-скрипт.
Для улучшения UX использовал встроенную валидацию HTML: required, minlength, type="date" и т.д.
Для ограниченных значений применил select и radio (реализация enum).

---

### Обработка данных на сервере

Ниже я реализовал:
 - Valdator (Проверка данных)
 - Storage (Сохранение в файл)
 - FormHandler (Управление формой)
 - process.php (связующий файл)

Класс `Validator.php`

```php 
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
```

Класс `Storage.php`

```php
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
```

Класс `FormHandler`

```php
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
```

Обработчик `process.php`

```php
<?php

require_once 'classes/FormHandler.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $handler = new FormHandler();
    $errors = $handler->handle($_POST);

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
        echo "<a href='index.php'>Назад</a>";
        exit;
    }

    header("Location: view.php");
    exit;
}
```
Я реализовал серверную обработку через ООП.
Создал отдельные классы: Validator для проверки данных и Storage для сохранения И FormHandler для обработки формы.
Это улучшает масштабируемость и разделение ответственности.

---

### Вывод данных

`view.php` — отображение таблицы игр

Назначение файла

- Читает данные из data.txt (JSON)
- Выводит их в виде HTML-таблицы
- Добавляет возможность сортировки по полям (через GET-параметр sort)

```php
$data = [];

if (file_exists('data.txt')) {
    $json = file_get_contents('data.txt');
    $data = json_decode($json, true) ?? [];
}
```

Чтение JSON-файла и преобразование в массив для дальнейшей работы. Если файл пустой или поврежден, используется пустой массив.

```php
$sort = $_GET['sort'] ?? '';

if ($sort) {
    usort($data, function ($a, $b) use ($sort) {
        return $a[$sort] <=> $b[$sort];
    });
}
```

Сортировка массива данных по выбранному полю. Пользователь выбирает поле через ссылку в таблице `(?sort=title)`, `usort()` выполняет сортировку.

```html
<table>
    <tr>
        <th><a href="?sort=title">Название</a></th>
        ...
    </tr>
    <?php foreach ($data as $game): ?>
        <tr>
            <td><?= $game['title'] ?></td>
            ...
        </tr>
    <?php endforeach; ?>
</table>
```
HTML-таблица для отображения всех записей. Ссылки на заголовках позволяют сортировать таблицу по разным полям.

```css
table {
    border-collapse: collapse;
    width: 100%;
}
th, td {
    border: 1px solid black;
    padding: 8px;
    text-align: center;
}
th {
    background-color: #ddd;
}
```

Минимальный CSS для удобочитаемости таблицы: рамки, отступы, фон заголовков.

#### process.php (с использованием FormHandler)

```php
require_once 'classes/FormHandler.php';

$handler = new FormHandler();
$errors = $handler->handle($_POST);
```

Класс `FormHandler` отвечает за получение данных из формы, их валидацию и сохранение через `Storage`.
`$errors` хранит ошибки валидации.

```php
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p style='color:red;'>$error</p>";
    }
    exit;
}

header("Location: view.php");
exit;
```

Если ошибки есть — выводим их пользователю. Если всё успешно — автоматически переходим на страницу таблицы.

#### FormHandler.php

Инкапсулирует логику работы с формой (ООП)

- Вызывает валидатор
- Формирует данные
- Сохраняет через Storage

Разделение ответственности (form -> validator -> storage) упрощает поддержку кода и делает проект модульным.

---

### Контрольные вопросы

1. Какие существуют методы отправки данных из формы на сервер? Какие методы поддерживает HTML-форма?

`GET` — данные передаются в URL, удобно для поиска или сортировки.
`POST` — данные передаются скрытно в теле запроса, удобно для формы добавления или редактирования данных.
HTML-форма поддерживает атрибут `method="get"` или `method="post"`.

2. Какие глобальные переменные используются для доступа к данным формы в PHP?

- `$_GET` — данные, переданные через URL-параметры.
- `$_POST` — данные, переданные методом POST.
- `$_REQUEST` — объединяет GET и POST (редко рекомендуется использовать).

3. Как обеспечить безопасность при обработке данных из формы (например, защититься от XSS)?

Использовать `htmlspecialchars()` при выводе данных в HTML, чтобы спецсимволы не выполнялись как код.
Валидировать и фильтровать вводимые данные (например, числа через `is_numeric()`, даты через `strtotime()`).
Не хранить «сырые» данные напрямую, если они будут отображаться пользователю.

---

### Заключение

В ходе работы была выполнена лабораторная работа по теме “HTML-формы и их обработка в PHP”:

1. Разработана форма добавления новой записи в мини-каталог пройденных игр.
2. Реализована серверная обработка данных с использованием ООП:
- Validator — проверка данных формы;
- Storage — сохранение данных в JSON-файл;
- FormHandler — объединяет валидацию и сохранение.
3. Данные выводятся на отдельной странице в виде HTML-таблицы с минимальным CSS и возможностью сортировки по разным полям.
4. Добавлены меры безопасности: фильтрация и экранирование данных `(htmlspecialchars)` для защиты от XSS.
5. Проект оформлен с использованием модульного подхода и OOP, что повышает читаемость и удобство поддержки кода.

Итог: лабораторная работа выполнена полностью с применением ООП . Все требования задания выполнены.
