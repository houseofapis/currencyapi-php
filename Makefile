.DEFAULT_GOAL := help
.PHONY: help
LOCAL_DOCKER_IMAGE=houseofapis/currencyapi-php
CONTAINER_NAME=currencyapi-php
WORKING_DIR=/application
PORT=7001
DOCKER_COMMAND=docker run --rm -v ${PWD}:${WORKING_DIR} -w ${WORKING_DIR} --name ${CONTAINER_NAME} -p ${PORT}:${PORT} -it ${LOCAL_DOCKER_IMAGE}

build: ## Build docker image
	docker build -t ${LOCAL_DOCKER_IMAGE} . --no-cache

test: ## Run the tests
	${DOCKER_COMMAND} ./vendor/bin/phpunit --coverage-clover build/logs/clover.xml

install: ## Composer install
	${DOCKER_COMMAND} composer install

compat: ## Run the tests
	${DOCKER_COMMAND} ./vendor/bin/phpcs -p ./tests --standard=PHPCompatibility --runtime-set testVersion 8.2

help:
	@grep -h -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'
