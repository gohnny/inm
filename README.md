# inm
***
Создать приложение Task Tracker с управлением задачами через API.

## Приложение должно содержать:

- Задачи
- Список пользователей на которых можно назначить задачу

## Возможные действия через API:

### Пользователь

- Регистрация пользователя

    Authorization - Bearer Token

- Вход для пользователя
- Редактирование данных у пользователя
- Удаление пользователя
- Получение данных пользователя

```json
Обязательные поля для пользователя в базе данных:
{
  "user_id": 1,
  "first_name": "First",
  "last_name": "Last",
	"email": "example@gmail.com",
  ...
}
```

### Пользователи

- Получение всех пользователей

    Должна присутствовать пагинация (лимит 10 пользователей на страницу)

### Задачи

- Создание задачи

    При создание задача должна быть присвоена ее создателю

- Редактирование задачи
- Изменить статус задачи

    Должны быть три возможных статуса: `["View", "In Progress", "Done"]`

- Удаление задачи
- Получение списка задач
    - Отфильтровав по статусу
    - Отсортировав по новым/старым пользователям
- Изменить пользователя на которого назначена задача

    Один пользователь имеет возможность назначить задачу другому пользователю

```json
Обязательные поля для задачи в базе данных:
{
  "id": 1,
  "title": "",
  "description": "",
	"status": "" // ["View", "In Progress", "Done"]
  ...
}
```

## Технические требования:

- Должен быть предоставлен `API (Postman, Swagger, ...)`
- Результат API запросов должен быть `в виде JSON`
- Результат задания должен быть выложен `на githb`
- Используется база данных `MySQL/PostgreSQL`

### Будет плюсом:

- Использовать `docker`
- Автоматическое заполнение `db`
- Написанные `тесты`
