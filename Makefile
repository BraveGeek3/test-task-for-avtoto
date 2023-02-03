PHP := php
CONSOLE := $(PHP) ./bin/console

build:
	#build and run containers detach
	docker-compose up -d --build

start:
	#detach by default
	docker-compose up -d

stop:
	#stopped but not removed
	docker-compose stop

down:
	#stop and remove
	docker-compose down

get-inside:
	#get into already running container
	docker exec -it ${container} /bin/bash

test:
	$(PHP) ./vendor/bin/phpunit --configuration phpunit.xml ./tests/

load-fixtures:
	$(CONSOLE) doctrine:fixtures:load --env=test

validate:
	$(CONSOLE) doctrine:schema:validate

diff:
	$(CONSOLE) doctrine:migrations:diff

migrate:
	$(CONSOLE) --no-interaction doctrine:migrations:migrate

install-assets:
	$(CONSOLE) --no-interaction assets:install --symlink

#To use outside docker
delete-containers:
	docker rm -f $$(docker ps -a -q)

delete-volumes:
	docker volume rm $$(docker volume ls -q)