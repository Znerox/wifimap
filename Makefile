all: build_aarch64

build_aarch64:
	docker build -t wifimap:aarch64 -f wifimap/Dockerfile --no-cache=true wifimap/
upload_aarch64:
	docker tag wifimap:aarch64 nulldevil/wifimap:aarch64
	docker push nulldevil/wifimap:aarch64
up_aarch64:
	COMPOSE_PROJECT_NAME=phpmyadmin COMPOSE_IGNORE_ORPHANS=True docker-compose -f docker-compose_aarch64_swarm.yml up -d
down_aarch64:
	COMPOSE_PROJECT_NAME=phpmyadmin COMPOSE_IGNORE_ORPHANS=True docker-compose -f docker-compose_aarch64_swarm.yml down
