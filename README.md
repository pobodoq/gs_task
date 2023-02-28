# Customers API

## Usage
1. docker-compose up
2. docker exec gstask_api php artisan migrate
3. http://localhost:8080

## Infrastructure
Run docker-compose up
```sh
docker-compose up
```
Run db migrations
```sh
docker exec gstask_api php artisan migrate
```
Run db:seed (OPTIONAL)
```sh
docker exec gstask_api php artisan db:seed
```

## Documentation
Generate OpenAPI documentation (already generated)
```sh
docker exec gstask_api php artisan l5-swagger:generate
```

View OpenAPI documentation
> http://localhost:8080

Postman collection
> [Postman collection](./GS.postman_collection.json)

## Tests
Run tests
```sh
php artisan test
```

## Analysis
Run static code analysis
```sh
./vendor/bin/phpstan analyse
```
