VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "ubuntu/trusty64"

  config.vm.network "forwarded_port", guest: 80, host: 8888
  config.vm.network "forwarded_port", guest: 3306, host: 8889

  config.vm.provision "shell", path: "provision.sh"

  config.vm.synced_folder "./", "/var/www/html", id: "vagrant-root",
      owner: "vagrant",
      group: "www-data",
      mount_options: ["dmode=775,fmode=775"]
end