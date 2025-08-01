# Каталог товаров

**ProductCatalog** — это легковесный модуль управления складом (тестовое задание), разработанный на Laravel. Он предоставляет RESTful API для управления категориями и товарами, а также поддерживает экспорт данных в Excel. Проект построен с соблюдением принципов чистой архитектуры с использованием паттернов Repository и Service и включает юнит-тесты для ключевой логики.

## Возможности

- Управление категориями и товарами через REST API  
- Экспорт данных товаров в Excel  
- Реализация паттернов Repository и Service  
- Наполнение базы данных с помощью фабрик  
- Покрытие бизнес-логики юнит-тестами  

---

## Установка

### С использованием Docker

1. Клонируйте репозиторий:
   ```bash
   git clone https://github.com/Lava15/product-catalog.git
   cd product-catalog
   ```

2. Скопируйте файл `.env.example`:
   ```bash
   cp .env.example .env
   ```

3. Запустите сборку и контейнеры:
   ```bash
   docker-compose up -d --build
   ```

4. Установите зависимости, выполните миграции и наполнение базы:
   ```bash
   docker exec -it php_app composer install
   docker exec -it php_app php artisan key:generate
   docker exec -it php_app php artisan migrate --seed
   ```

5. Запустите очередь:
   ```bash
   docker exec -it php_app php artisan queue:listen --tries=3 --timeout=180
   ```
---

### Без использования Docker

> Требуется PHP 8.4+, Composer, MySQL/PostgreSQL

1. Клонируйте репозиторий и перейдите в папку проекта:
   ```bash
   git clone https://github.com/Lava15/product-catalog.git
   cd product-catalog
   ```

2. Установите зависимости:
   ```bash
   composer install
   ```

3. Скопируйте `.env` файл и настройте подключение к БД:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Выполните миграции и наполнение базы:
   ```bash
   php artisan migrate --seed
   ```

5. Запустите очередь:
   ```bash
   php artisan queue:listen --tries=3 --timeout=180
   ```

6. Запустите локальный сервер:
   ```bash
   php artisan serve
   ```

---

## Тестирование

```bash
php artisan test
```
