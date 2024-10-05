.DEFAULT_GOAL := help
.PHONY: help
LOCAL_DOCKER_IMAGE=houseofapis/currencyapi-php
CONTAINER_NAME=currencyapi-php
WORKING_DIR=/application
PORT=7005
DOCKER_COMMAND=docker run --rm -v ${PWD}:${WORKING_DIR} -w ${WORKING_DIR} --name ${CONTAINER_NAME} -p ${PORT}:${PORT} -it ${LOCAL_DOCKER_IMAGE}

build: ## Build docker image
	docker build -t ${LOCAL_DOCKER_IMAGE} . --no-cache

test: ## Run the tests
	${DOCKER_COMMAND} php -d xdebug.mode=coverage ./vendor/bin/phpunit --coverage-html build/logs/coverage.html

install: ## Composer install
	${DOCKER_COMMAND} composer install

run: ## Run test file
	${DOCKER_COMMAND} php run.php

help:
	@grep -h -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'
