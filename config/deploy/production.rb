############################################
# Setup Server
############################################

set :stage, :production
set :stage_url, "http://chadjewsbury.com"
server "45.55.163.89", user: "serverpilot", roles: %w{web app db}
set :deploy_to, "/var/www/apps/#{fetch(:application)}"

############################################
# Setup Git
############################################

set :branch, "master"

############################################
# Extra Settings
############################################

#specify extra ssh options:

#set :ssh_options, {
#    auth_methods: %w(password),
#    password: 'password',
#    user: 'username',
#}

#specify a specific temp dir if user is jailed to home
#set :tmp_dir, "/path/to/custom/tmp"
