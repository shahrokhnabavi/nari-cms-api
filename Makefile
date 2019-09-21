.DEFAULT_GOAL := help

RED := \033[31m
GREEN := \033[32m
YELLOW := \033[33m
BLUE := \033[34m
MAGENTA := \033[35m
CYAN := \033[36m
LIGHT_GRAY := \033[37m
DARK_GRAY := \033[90m
DEFAULT := \033[39m

ENV := development
VENDOR := ./vendor/bin

DOCKER := true
DOCKER_NETWORK := bridge
OS := $(shell uname)
HOST_IP := $(shell ifconfig | sed -En 's/127.0.0.1//;s/.*inet (addr:)?(([0-9]*\.){3}[0-9]*).*/\2/p' | sed -n 1p)

ifeq ($(DOCKER),true)
SRART_COMMAND := docker run --rm -it --init --net=${DOCKER_NETWORK} --volumes-form=site-data site-api
else
START_COMMAND :=
endif

NODE_MODULES := ./node_modules/.bin
GIT_STAGED_COMMAND := git --no-pager diff --staged --name-only --diff-filter="AM"


.PHONY: help
help:
	@echo ''
	@echo 'To install development envinronment use: make install'
	@echo ''
	@echo 'To run a task: make [task_name] ARGS=[your-arguments]'
	@echo "\tExample: make test_acceptance ARGS='-g debug -vvv'"
	@echo ''
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "%s%-20s%s %s%s\n", "${CYAN}", $$1, "${CYAN}${LIGHT_GRAY}", $$2, "${LIGHT_GRAY}${DEFAULT}"}'
	@echo ''

.PHONY: install
install: ## Install application and all depenancies
	echo "${RED}${OS} ${RED}"

.PHONY: php_linting
php_linting: ## Check php code style
	php ${VENDOR}/phpcs

.PHONY: php_linting_fix
php_linting_fix: ## Fix php code style errors
	php ${VENDOR}/phpcbf

.PHONY: test_acceptance
test_acceptance: ## Run all acceptance test
	echo "${RED}${OS} ${RED}"

.PHONY: test_unit
test_unit: ## Run all unit tests
	echo "${RED}${OS} ${RED}"
