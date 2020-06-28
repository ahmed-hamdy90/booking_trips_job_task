# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure(2) do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://atlas.hashicorp.com/search.
  config.vm.box = "ubuntu/bionic64"

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  # config.vm.box_check_update = false

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  config.vm.network "forwarded_port", guest: 80, host: 8686
  #config.vm.network "forwarded_port", guest: 8000, host: 8000

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  config.vm.network "private_network", ip: "192.168.33.70"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  config.vm.synced_folder "./vagrant/nginx/sites-available", "/etc/nginx/sites-available"
  config.vm.synced_folder "./src", "/var/www/src", owner: "vagrant", group: "vagrant"
  config.vm.synced_folder "./src/storage", "/var/www/src/storage", owner: "vagrant", group: "www-data", mount_options: ['dmode=777', 'fmode=777']
  config.vm.synced_folder "./src/bootstrap/cache", "/var/www/src/bootstrap/cache", owner: "vagrant", group: "www-data", mount_options: ['dmode=777', 'fmode=777']

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  # Example for VirtualBox:
  #
  config.vm.provider "virtualbox" do |vb|
  #   # Display the VirtualBox GUI when booting the machine
  #   vb.gui = true
  #
     # Customize the amount of memory on the VM:
     vb.memory = "2024"
     # Customize VM name:
     vb.name = "Robusta-Task"
  end
  #
  # View the documentation for the provider you are using for more
  # information on available options.

  # Define a Vagrant Push strategy for pushing to Atlas. Other push strategies
  # such as FTP and Heroku are also available. See the documentation at
  # https://docs.vagrantup.com/v2/push/atlas.html for more information.
  # config.push.define "atlas" do |push|
  #   push.app = "YOUR_ATLAS_USERNAME/YOUR_APPLICATION_NAME"
  # end

  # Enable provisioning with a shell script. Additional provisioners such as
  # Puppet, Chef, Ansible, Salt, and Docker are also available. Please see the
  # documentation for more information about their specific syntax and use.
   config.vm.provision "shell", inline: <<-INSTALLATION
    echo "update Ubuntu Dependencies ===================================>"
    sudo apt-get update
    echo "Add PPA repository for php 7.x ===========================>"
    sudo add-apt-repository -y ppa:ondrej/php
    echo "update Ubuntu Dependencies ===================================>"
    sudo apt-get update
    echo "Install nginx ========================================>"
    sudo apt-get -y install nginx
    sudo /etc/init.d/nginx start
    echo "install snmp ===================================================>"
    sudo apt-get -y install snmp
    echo "install mysql ===================================================>"
    sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
    sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'
    sudo apt-get -y install mysql-client mysql-server
    ecgo "create new vagrant user and task DB ================>"
    mysql -u root -p'root' -e "CREATE USER 'vagrant'@'localhost' IDENTIFIED BY 'vagrant';"
    mysql -u root -p'root' -e "GRANT ALL PRIVILEGES ON * . * TO 'vagrant'@'localhost';"
    mysql -u root -p'root' -e "FLUSH PRIVILEGES;"
    mysql -u vagrant -p'vagrant' -e "DROP DATABASE IF EXISTS rubosta_task_db;"
    mysql -u vagrant -p'vagrant' -e "CREATE DATABASE rubosta_task_db;"
    echo "Install php 7.2 and some dependencies for php 7.2 ============>"
    sudo apt-get -y install php7.2-fpm
    sudo apt-get -y install libsqlite3-dev zziplib-bin php-pear php7.2-imap php7.2-mcrypt php7.2-pspell php7.2-recode
    sudo apt-get -y install php7.2-snmp php7.2-tidy php7.2-xmlrpc php7.2-xsl php-memcached php7.2-cli php7.2-zip
    sudo apt-get -y install php7.2-soap php7.2-mysql php7.2-gd php7.2-mbstring
    echo "Removing default nginx files ==================================>"
    rm -rf /etc/nginx/sites-available/default
    rm -rf /etc/nginx/sites-enabled/default
    echo "Adding new nginx conf and edit php.ini =========================================>"
    sudo ln -s /etc/nginx/sites-available/app.conf /etc/nginx/sites-enabled/
    sudo sed -i.bak $'s/display_errors = Off/display_errors = On/g' /etc/php/7.2/fpm/php.ini
    sudo sed -i.bak $'s/display_startup_errors = Off/display_startup_errors = On/g' /etc/php/7.2/fpm/php.ini
    echo "Restart nginx and php7.2-fpm Services ================="
    sudo service nginx restart
    sudo service php7.2-fpm restart
    echo "update Ubuntu Dependencies ===================================>"
    sudo apt-get update
    echo "install git ===================================================>"
    sudo apt-get install -y git
    echo "install curl ===================================================>"
    sudo apt-get install -y curl
    echo "install composer ===================================================>"
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
    sudo chown vagrant /usr/local/bin/composer
    sudo chgrp vagrant /usr/local/bin/composer
    echo "Fix some issues related to install Laravel installer CLI ================>"
    composer global config bin-dir --absolute
    composer global update
    sudo /bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024
    sudo /sbin/mkswap /var/swap.1
    sudo /sbin/swapon /var/swap.1
    echo "install Laravel installer CLI =================================>"
    composer global require laravel/installer
    echo "install packages dependencies of application =================================>"
    cd /var/www/src/ && composer install
    echo "Run migrations and seeders for application =============================>"
    php artisan migrate:fresh --force
    php artisan db:seed --force
   INSTALLATION

   config.vm.provision :shell, run: "always", inline: <<-RESTART_NGINX
       sudo service nginx restart
   RESTART_NGINX
end
