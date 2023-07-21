#!make

SHELL = /bin/sh

CURRENT_UID := $(shell id -u)
CURRENT_GID := $(shell id -g)

export CURRENT_UID
export CURRENT_GID

.DEFAULT_GOAL := help

PHPUNIT = vendor/bin/phpunit -c "phpunit.xml.dist"
PSALM = vendor/bin/psalm --no-cache
PHPCS = vendor/bin/phpcs --exclude=Generic.Files.LineLength,PSR1.Files.SideEffects --standard=PSR12 src/ tests/
PHPCBF = vendor/bin/phpcbf --standard=PSR12 src/ tests/

##
## Composer

vendor/autoload.php: ## Install dependencies
	@echo "Performing composer install to install dependencies"
	-@mkdir -p "$(HOME)/.composer"
	composer install --no-interaction --no-scripts --ignore-platform-reqs

##
## Tests
.PHONY: tests phpunit behat psalm phpcs

tests: phpunit psalm phpcs ## Run tests

phpunit: vendor/autoload.php ## Run PHPUnit
	@$(PHPUNIT)

psalm: vendor/autoload.php ## Run Psalm Static Analysis
	@$(PSALM) src tests

phpcs: vendor/autoload.php ## Run PHP Code Sniffer
	@$(PHPCS)

phpcbf: vendor/autoload.php ## Run PHP Code Style Fixer
	@$(PHPCBF)

##
## Utils
.PHONY: purge-vendor clean

purge-vendor: ## Purge vendor
	-@rm -rf ./vendor/*
	@echo "Removing vendor"

clean: purge-vendor ## Strip the project back to source files
	@rm -rf ./.phpunit.result.cache
	@rm -rf ./composer.lock

##
## Help
.PHONY: help

help: ## List of all commands
	@grep -E '(^[a-zA-Z_\.-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | sed -e 's/Makefile://' | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m## /[33m/'
