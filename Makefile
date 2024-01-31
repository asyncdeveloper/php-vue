up:
	docker compose up
remake:
	docker compose up --build
restart:
	@make down
	@make up
destroy:
	docker compose exec server rm -rf vendor/
	docker compose exec server rm -rf .env
	docker compose exec client rm -rf node_modules/
	docker compose down --volumes --remove-orphans
down:
	docker compose down --remove-orphans --volumes
run-tests:
	docker compose exec app composer test
