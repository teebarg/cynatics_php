Business Listings App
Employee App is a simple app to demostrate CRUD Operation. Laravel is used for the API and Vuejs for frontend

Table of Contents

Installation
Usage
Installation

# clone the repo
$ git clone https://github.com/teebarg/ade-seamless.git my-project

# go into app's directory
$ cd my-project

# install app's dependencies
$ composer install

# install app's dependencies
$ npm install
Setup Your Database (Mysql Example Below)

Copy file ".env.example", and change its name to ".env". Then in file ".env" complete this database configuration:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=your-password
Next step

# in your app directory
# generate laravel APP_KEY
$ php artisan key:generate


# run database migration
$ php artisan migrate:refresh --seed


Usage

# start local server
$ php artisan serve

