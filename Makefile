export UID=$(shell id -u)
export GID=$(shell id -g)

include .env
-include .env.local
export

DOCKER_COMPOSE_OPTIONS := -f docker-compose.yaml
DOCKER_COMPOSE         := docker compose $(DOCKER_COMPOSE_OPTIONS)
PHP                    := $(DOCKER_COMPOSE) run --rm php-fpm php
PHP_CONTAINER_SHELL    := $(DOCKER_COMPOSE) run --rm php-fpm
COMPOSER_BIN           := $(DOCKER_COMPOSE) run --rm php-fpm composer

##
## Проект
## ------

cert:
	mkcert -install
	mkcert -cert-file ./docker/traefik/php-russia-2024-yii2.local.crt -key-file ./docker/traefik/php-russia-2024-yii2.local.key "*.php-russia-2024-yii2.local"
.PHONY: cert

hosts:
	sudo sh -c "echo '127.0.0.1 api.php-russia-2024-yii2.local' >> /etc/hosts"
	sudo sh -c "echo '127.0.0.1 traefik.php-russia-2024-yii2.local' >> /etc/hosts"
	sudo sh -c "echo '127.0.0.1 minio.php-russia-2024-yii2.local' >> /etc/hosts"
	sudo sh -c "echo '127.0.0.1 s3.php-russia-2024-yii2.local' >> /etc/hosts"
.PHONY: hosts

init: cert hosts
.PHONY: init

var:
	mkdir -p var
.PHONY: var

vendor:
	$(COMPOSER_BIN) install
.PHONY: vendor

update: ## Обновить пакеты
	$(COMPOSER_BIN) update
	$(COMPOSER_BIN) bump
	touch vendor
.PHONY: update

up: var vendor ## Запустить приложение
	$(DOCKER_COMPOSE) up --build --remove-orphans --detach
.PHONY: up

down: ## Остановить приложение
	$(DOCKER_COMPOSE) down --remove-orphans
.PHONY: stop

##
## Качество кода
## ------

check: rector cs psalm composer ## Запустить все проверки качества кода
.PHONY: check

psalm: var vendor ## Запустить полный статический анализ PHP кода при помощи Psalm (https://psalm.dev/)
	$(PHP) vendor/bin/psalm --no-diff
.PHONY: psalm

cs: var vendor ## Проверить PHP code style при помощи PHP CS Fixer (https://github.com/FriendsOfPHP/PHP-CS-Fixer)
	PHP_CS_FIXER_IGNORE_ENV=1 $(PHP) vendor/bin/php-cs-fixer fix --dry-run --diff --using-cache=yes -v
.PHONY: cs

fixcs: var vendor ## Исправить ошибки PHP code style при помощи PHP CS Fixer (https://github.com/FriendsOfPHP/PHP-CS-Fixer)
	PHP_CS_FIXER_IGNORE_ENV=1 $(PHP) vendor/bin/php-cs-fixer fix --using-cache=yes -v
.PHONY: fixcs

rector: var vendor ## Запустить полный анализ PHP кода при помощи Rector (https://getrector.org)
	$(PHP) vendor/bin/rector process --dry-run
.PHONY: rector

rector-fix: var vendor ## Запустить исправление PHP кода при помощи Rector (https://getrector.org)
	$(PHP) vendor/bin/rector process
.PHONY: rector-fix

composer: composer-validate composer-require composer-unused composer-audit composer-normalize ## Запустить все проверки Composer
.PHONY: composer

composer-validate: ## Провалидировать composer.json и composer.lock при помощи composer validate (https://getcomposer.org/doc/03-cli.md#validate)
	$(COMPOSER_BIN) validate --strict --no-check-publish
.PHONY: composer-validate

composer-require: vendor ## Обнаружить неявные зависимости от внешних пакетов при помощи ComposerRequireChecker (https://github.com/maglnet/ComposerRequireChecker)
	$(PHP) vendor/bin/composer-require-checker check --config-file=composer-require-checker.json
.PHONY: composer-require

composer-unused: vendor ## Обнаружить неиспользуемые зависимости Composer при помощи composer-unused (https://github.com/icanhazstring/composer-unused)
	$(PHP) vendor/bin/composer-unused
.PHONY: composer-unused

composer-audit: ## Обнаружить уязвимости в зависимостях Composer при помощи composer audit (https://getcomposer.org/doc/03-cli.md#audit)
	$(COMPOSER_BIN) audit
.PHONY: composer-audit

composer-normalize: ## Нормализация composer.json. Анализ (https://github.com/ergebnis/composer-normalize)
	$(COMPOSER_BIN) normalize --dry-run
.PHONY: composer-normalize

composer-normalize-fix: ## Нормализация composer.json (https://github.com/ergebnis/composer-normalize)
	$(COMPOSER_BIN) normalize
.PHONY: composer-normalize-fix