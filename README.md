Тестовое для LinkAge, с использованием Laravel, MariaDB, и Nginx.

Перед поднятием приложения необходимо создать файл .env и заполнить его по шаблону .env.example. Ключевые для работы 
константы начинаются с коммента "реквизиты для клиента amoCRM".

---

Для того чтобы поднять приложение:
``docker compose up --build -d``

Запустить миграции: ``docker exec php_app php artisan migrate``

Запуск воркера очередей: ``docker exec php_app php artisan queue:work``

Маршрут для вебхука: ``localhost:8080/api/webhook``

---

Данные должны быть в формате JSON с полями: 

``name`` : ``string`` (макс. 255 символов)

``phone`` - номер телефона формата РФ

``apartment_address`` : ``string`` - адрес желаемого объекта для аренды (макс. 255  символов)
