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

ifeq ($(DOCKER),)
	DOCKER := true
	DOCKER_NETWORK := bridge
	OS := $(shell uname)
	HOST_IP := $(shell ifconfig | sed -En 's/127.0.0.1//;s/.*inet (addr:)?(([0-9]*\.){3}[0-9]*).*/\2/p' | sed -n 1p)
endif

ifeq ($(DOCKER),true)
	START_COMMAND := docker-compose exec site_api_php
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
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "%s%-20s%s %s%s\n", "${CYAN}", $$1, "${LIGHT_GRAY}", $$2, "${DEFAULT}"}'
	@echo ''

.PHONY: install
install: ## Install development environment and all depenancies
	@./scripts/install-development
	@echo ''

.PHONY: php_lint
php_lint: ## Check php code style
	@echo "${YELLOW}The process php_lint is started.${DEFAULT}"
	${START_COMMAND} php ${VENDOR}/phpcs
	@echo ''

.PHONY: php_lint_fix
php_lint_fix: ## Fix php code style errors
	@echo "${YELLOW}The process php_lint_fix is started.${DEFAULT}"
	${START_COMMAND} php ${VENDOR}/phpcbf
	@echo ''

.PHONY: test_acceptance
test_acceptance: ## Run all acceptance test
	echo "${RED}${OS} ${RED}"

.PHONY: test_unit
test_unit: ## Run all unit tests
	${START_COMMAND} php ${VENDOR}/phpunit -c phpunit.xml --testsuite Units
