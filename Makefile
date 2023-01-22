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