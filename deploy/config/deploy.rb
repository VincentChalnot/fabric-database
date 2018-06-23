set :application, "fabric-database"
set :repo_url, "git@github.com:VincentChalnot/fabric-database.git"
set :ssh_options, { :forward_agent => true }

append :linked_files, "app/config/parameters.yml"
append :linked_dirs, "var/data", "var/logs", "var/sessions", "web/images/cache"

# set :default_env, { path: "~/.composer/vendor/bin:$PATH" }

set :keep_releases, 3

set :symfony_console_flags, "--no-debug --env=prod"

after :deploy, "phpfpm:restart"
