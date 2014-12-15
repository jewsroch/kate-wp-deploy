############################################
# Setup WordPress
############################################

set :wp_user, "username" # The admin username
set :wp_email, "email" # The admin email address
set :wp_sitename, "WordPress Site Name" # The site title
set :wp_localurl, "http://localhost" # Your local environment URL

############################################
# Setup project
############################################

set :application, "application_name"
set :repo_url, "git@github.com:username/repo.git"
set :scm, :git