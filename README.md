# Share your Iftar Project

## Documentation

https://docs.google.com/document/d/1VLw98wvg7Yyq46QgAv5rYjwUJCk4Uwb_dC9OBWCLvaQ/view

## About the project

### OVERVIEW

Share the Iftar allows the community to share their iftar meal with others. Iftar at the Mosques were a community affair, providing a quality meal for the Fasting Muslim. With COVID 19 this will not be possible this year and many members from our community will suffer in shyness and silence. Staying hungry and not being able to afford regular meals, due to the current financial difficulties.

### GOALS

- Allow people to donate meals.
- Allow those who want a meal to pick up or have meals delivered.

## About this repo

This is the Backend API microservice for the Share your Iftar Project.

This project was written using Laravel (https://laravel.com/). Laravel is a web application framework written in PHP. It has prebuilt components that allowed the project to swiftly start.

### Prerequisites

1. Composer (https://getcomposer.org/download/)
2. PHP 7.2
3. NodeJS

(This will be replaced by a DockerFile soon)

### Getting started

```
cp .env.example .env
composer install;
php artisan key:generate;
npm install;
npm run dev;
```

### Running migrations

```
php artisan migrate
```

### Running the app locally

```
php artisan serve
```

### How to run test

```
php artisan test
```
