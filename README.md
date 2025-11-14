Тестовое для LinkAge, с использованием Laravel, MariaDB, и Nginx.

Перед поднятием приложения необходимо создать файл .env и заполнить его по шаблону .env.example. Ключевые для работы 
константы начинаются с коммента "реквизиты для клиента amoCRM".

Для того чтобы поднять приложение:
``docker compose up --build -d``

Запустить миграции: ``docker exec php_app php artisan migrate``
