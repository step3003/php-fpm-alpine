test:
	cd tests \
	&& docker-compose build \
	&& docker-compose run --rm php composer install \
	&& docker-compose up 