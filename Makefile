# If the first argument is "run-tests"...
ifeq (run-tests,$(firstword $(MAKECMDGOALS)))
  # use the rest as arguments for "run-tests"
  TESTS_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
  # ...and turn them into do-nothing targets
  $(eval $(TESTS_ARGS):;@:)
endif

GENERATED_FILES = composer.lock var vendor .php-cs-fixer.cache .phpunit.result.cache .symfony.lock

UID = $(shell id -u)
export UID


DOCKER_HOST_IP = $(shell ip addr show docker0 | awk '/^[[:space:]]*inet / { split($$2, a, "/"); print iface a[1] }')
export DOCKER_HOST_IP

composer.lock vendor : composer.json | var/docker.lock
	$(MAKE) install-composer-requirements

var :
	mkdir -p var

var/githooks.lock : | var
	$(MAKE) install-git-hooks

var/docker.lock : $(wildcard infrastructure/*) | var
	$(MAKE) build-docker-image

.PHONY : bash build-docker-image check-code-style clean fix-code-style init install-composer-requirements install-git-hooks start-server run-tests

bash: var/docker.lock vendor
	docker compose run --rm cli

build-docker-image:
	docker build -f infrastructure/Dockerfile --tag overkill-fibonacci $(PWD)
	echo $(shell docker images --format '{{ .ID }}' overkill-fibonacci:latest) > var/docker.lock

check-code-style:
	docker compose run --rm -T cli vendor/bin/php-cs-fixer check

clean:
	rm -Rf $(GENERATED_FILES)
	docker compose down --remove-orphans --rmi local
	docker rmi -f overkill-fibonacci
	git config --local --unset-all core.hooksPath

fix-code-style:
	docker compose run --rm cli vendor/bin/php-cs-fixer fix

init: var/docker.lock var/githooks.lock vendor

install-composer-requirements:
	docker compose run --rm cli composer install

install-git-hooks:
	git config --local --add core.hooksPath ./bin/githooks
	touch var/githooks.lock

start: var/docker.lock vendor
	docker compose up -d

stop:
	docker compose down

run-tests: var/docker.lock vendor
	docker compose run --rm cli composer run-tests -- $(TESTS_ARGS)
