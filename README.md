# ProductWarehouse-backend

## How run application locally with docker-compose - not working 
Type in terminal:

```
docker-compose up --build
```

## Working application run:
First run in terminal below command:
```
docker-compose up --build
```
Next get docker mysql container port after the container is builded, it should be 33060.

Now create .env file based on example file and in value `DB_PORT` write port of your container. Also add `password` in field `DB_PASSWORD`
```
cp .env.example .env
```
Next run commands 
``` 
composer install
php artisan key:generate
php artisan migrate --seed
php artisan passport:client --personal
php artisan serve

```

Now your backend should work 
