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

migrate:
	docker-compose exec app bash
	php artisan migrate
	# start job
	php artisan queue:work
	# close job
	php artisan queue:forget job-id

 