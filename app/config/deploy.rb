set :application, "clanmanager"
#set :domain,      "#{application}.com"
set :domain,      "#{application}"
#set :deploy_to,   "/var/www/#{domain}"
set :app_path,    "app"
#set :user,"pi"

set  :keep_releases,  3
after "deploy", "deploy:cleanup"

#set :repository,  "#{domain}:/var/repos/#{application}.git"
set :repository,  "https://github.com/robhaverkort/clanmanager.git"
set :scm,         :git
set :scm_username,"robhaverkort"

# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :model_manager, "doctrine"
# Or: `propel`

#role :web,        domain                         # Your HTTP server, Apache/etc
#role :app,        domain, :primary => true       # This may be the same as your `Web` server

#role :web,        "192.168.0.12"                         # Your HTTP server, Apache/etc
#role :app,        "192.168.0.12", :primary => true       # This may be the same as your `Web` server

set :shared_files, ["app/config/parameters.yml"]

#new
#set :shared_children,     [app_path + "/logs", web_path + "/uploads", "vendor"]
set :shared_children,     [app_path + "/logs", web_path + "/uploads"]
set :use_composer, false
set :update_vendors, false

task :production do
  role :web, "www.rhbv.nl"
  role :app, "www.rhbv.nl"
  role :db, "www.rhbv.nl"
  set :deploy_to, "/home/rhbv/domains/rhbv.nl/private_html/clanmanager"
  set :user, "rhbv"
  set :use_sudo, false
  set :deploy_via, :copy
end

task :staging do
  role :web, "192.168.0.12"
  role :app, "192.168.0.12"
  role :db, "192.168.0.12"
  set :deploy_to, "/var/www/clanmanager"
  set :user, "pi"
end



# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL
