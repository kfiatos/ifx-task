ifeq ($(docker compose),)
	DOCKER_COMPOSE = docker-compose
else
	DOCKER_COMPOSE = docker compose
endif

PHP_SHELL = docker exec -it app_php83

build:
	$(DOCKER_COMPOSE) -f ./docker/docker-compose.yml build --progress=plain --no-cache

start:
	$(DOCKER_COMPOSE) -f ./docker/docker-compose.yml up -d

stop:
	$(DOCKER_COMPOSE) -f ./docker/docker-compose.yml stop

full-start: build start wait composer database migrations

cleanup: stop
	docker system prune -a

composer:
	$(PHP_SHELL) composer install
	$(PHP_SHELL) vendor/bin/codecept build
	$(PHP_SHELL) php bin/console cache:clear
	$(PHP_SHELL) php bin/console cache:warmup

wait:
	echo "[SLEEP 30] Waiting for containers to start up"
	sleep 30

database:
	$(PHP_SHELL) php bin/console doctrine:database:create --if-not-exists
	$(PHP_SHELL) php bin/console doctrine:database:create --env=test --if-not-exists

migrations:
	$(PHP_SHELL) php bin/console doctrine:migrations:migrate
	$(PHP_SHELL) php bin/console doctrine:migrations:migrate --env=test



test-unit:
	$(PHP_SHELL) bin/phpunit tests/unit

test: test-unit test-integration test-api

shell:
	$(PHP_SHELL) bash

php-stan:
	$(PHP_SHELL) vendor/bin/phpstan analyse

php-cs:
	$(PHP_SHELL) vendor/bin/php-cs-fixer fix --allow-risky=yes


