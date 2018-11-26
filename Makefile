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