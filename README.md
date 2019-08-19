# Recipes App

A symfony 4 app to track recipes in a database.

## Setting up and Preparing to Run the App

   * Install PHP 7.x and php-xml
   * `php ./composer.phar install`
   * Install mysql or mariadb and php7.x-mysql
   * Make sure DB is running `sudo systemctl status mariadb`
   * Run mysql_secure_install and set up root password
   * Using a root shell, log in as root
   * Create a user for symfony, and the database
   * Adjust mysql connection string in .env
   * run `bin/console doctrine:migrations:migrate` to create DB tables
   * Add a user

## Running the App

   * `php bin/console server:run`
   * open localhost:8000/dashboard in your browser

