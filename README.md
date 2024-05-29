# Установка и запуск

1. Склонировать проект из репозитория:   
    ```bash
    git clone <your-repo-url>
    ```

2. Перейти в директорию проекта:
    ```bash 
    cd <your-repo-name>
    ```

3. Установить зависимости:
    ```bash
    composer install
    ```

4. Скопировать конфигурационный файл окружения из примера:  
    ```bash
    cp .env.example .env
    ```

5. В файле окружения .env прописать настройки подключения к базе данных и изменить другие настройки (если необходимо):  
    ```bash
    DB_CONNECTION=sqlsrv
    DB_HOST=localhost
    DB_PORT=1433
    DB_DATABASE=employee_support
    DB_USERNAME=sa
    DB_PASSWORD=
    ```

6. Создать базу данных с именем и пользователем, прописанными ранее в файле окружения .env (см. пункт 5).  

7. Выполнить миграции:  
   ```bash
   php artisan migrate
   ```

8. Создать учётную запись администратора:  
   ```bash
   php artisan app:create-admin
   ```

9. Настроить и запустить один из веб-серверов на выбор:  
   - Nginx,  
   - Apache,  
   - или встроенный для локальной разработки:  
   ```bash
   php artisan serve
   ```


# Разработка и тестирование

Команда для быстрого наполнения сайта тестовыми данными и запуска встроенного локального сервера:      
_⚠️База данных будет перезаписана!_ 
```bash
php artisan optimize:clear \
&& php artisan cache:clear \
&& php artisan migrate:fresh \
&& php artisan app:create-admin --auto \
&& php artisan db:seed \
&& php artisan serve
```
