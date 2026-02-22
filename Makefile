.DEFAULT_GOAL := help
.PHONY: help
LOCAL_DOCKER_IMAGE=houseofapis/currencyapi-php
CONTAINER_NAME=currencyapi-php
WORKING_DIR=/app
PORT=7005
# Use official image so test/run work without building
DOCKER_IMAGE ?= composer:2
DOCKER_RUN = docker run --rm -v ${PWD}:${WORKING_DIR} -w ${WORKING_DIR} --name ${CONTAINER_NAME} -p ${PORT}:${PORT}
DOCKER_RUN_IT = docker run --rm -v ${PWD}:${WORKING_DIR} -w ${WORKING_DIR} --name ${CONTAINER_NAME} -p ${PORT}:${PORT} -it

build: ## Build docker image
	docker build -t ${LOCAL_DOCKER_IMAGE} . --no-cache

test: ## Run the tests (no build required)
	${DOCKER_RUN} ${DOCKER_IMAGE} sh -c "composer install --no-interaction && ./vendor/bin/phpunit"

install: ## Composer install
	${DOCKER_RUN} ${DOCKER_IMAGE} composer install --no-interaction

run: ## Run the run file (no build required)
	${DOCKER_RUN_IT} ${DOCKER_IMAGE} sh -c "composer install --no-interaction && php run.php"

help:
	@grep -h -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'
