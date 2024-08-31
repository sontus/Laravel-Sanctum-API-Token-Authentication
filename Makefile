setup:
	@make build
	@make up
	@make composer-update
build:
	docker-compose build --no-cache --force-rm
stop:
	docker-compose stop
up:
	docker-compose up -d
composer-update:
	docker exec Laravel-Sanctum-API-Token-Authentication bash -c "composer update"
	docker exec Laravel-Sanctum-API-Token-Authentication bash -c "chown -R www-data:www-data *"
data:
	docker exec Laravel-Sanctum-API-Token-Authentication bash -c "php artisan migrate"
	docker exec Laravel-Sanctum-API-Token-Authentication bash -c "php artisan db:seed"
