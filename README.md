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
Next get docker mysql container port, it should be 33060.

Now create .env file based on example file and in value `DB_PORT` write port of your container.
```
cp .env.example .env
```
Next run commands 
```
php artisan key:generate 
composer install
php artisan migrate --seed
php artisan passport:client --personal
php artisan serve

```

Now your backend should work 
