.PHONY: help
help: ## This help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(TARGETS) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

DC ?= cd docker && docker-compose
DCE ?= cd docker && docker-compose exec www

-include docker/.env
docker/.env:
	cp docker/.env.dist docker/.env
	$(MAKE) docker/.env

.PHONY: install
install: start ## Run docker instance and launch composer install
	$(DCE) composer install

.PHONY: start
start: docker/.env ## Start docker
	$(DC) up --build -d

.PHONY: stop
stop: ## Stop and destroy docker images
	$(DC) down --remove-orphans

.PHONY: cc
cc: ## Clear Symfony cache
	rm -rf var/cache/*

.PHONY: shell
shell: start ## Starts a shell in the main container
	$(DCE) zsh -c "export COLUMNS=`tput cols`; export LINES=`tput lines`; exec zsh"

.PHONY: docker-status
docker-status: ## Diplay containers status
	$(DC) ps

.PHONY: deploy-production
deploy-production: ## Deploy to production
	$(DC) run deploy cap prod deploy

CURRENT_DATE := $(shell date +"%Y-%m-%d")
remoteHost ?= vincent@54.36.189.137
outputFile := fabric-$(CURRENT_DATE).sql.gz
remoteBasePath ?= /home/www-data/sites/database.lanaria/current
remotePath := $(remoteBasePath)/var/data/$(outputFile)
dumpCmd := php $(remoteBasePath)/bin/console --env=prod sidus:database:mysqldump | gzip -c > "$(remotePath)"

.PHONY: fetch-prod-database
fetch-prod-database: start backups ## Fetch production database locally
	@echo "Dumping remote database to $(remotePath)"
	ssh $(remoteHost) "$(dumpCmd)"

	@echo "Copying dump file to local path backups/$(outputFile)"
	scp -C $(remoteHost):"$(remotePath)" "backups/$(outputFile)"

.PHONY: load-prod-database
load-prod-database: start ## Load the production database locally
	@echo "Loading production database from backups/$(outputFile)"
	$(DCE) sh -c "pv backups/$(outputFile) | zcat | php bin/console sidus:database:mysql"

backups:
	mkdir backups

.PHONY: fetch-assets
fetch-assets:
	rsync -r -t -p -x -v --progress --ignore-existing --partial -s $(remoteHost):$(remoteBasePath)/var/data/resources/ var/data/resources
