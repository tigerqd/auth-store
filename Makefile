# Docker compose wrapper
# Use with make up as example

.DEFAULT_GOAL := up

ps:
	docker-compose ps

restart:
	docker-compose restart

buid:
	docker-compose build

up:
	docker-compose build && docker-compose up -d

down:
	docker-compose down

php:
	docker-compose exec auth-backend bash

phpcs:
	docker-compose exec auth-backend vendor/bin/php-cs-fixer fix src/ --using-cache=no --rules=@Symfony --diff

phpstan:
	docker-compose exec auth-backend vendor/phpstan/phpstan/bin/phpstan analyze -l 1 --memory-limit=1024M -c phpstan.neon core/

consumer:
	docker-compose exec auth-backend  bin/console messenger:consume-messages amqp