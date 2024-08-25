# Laravel Quoter Application

## Overview

The Laravel Quoter application is a simple web application built with Laravel 11 and vuejs.

The application implements a quote manager driver for receiving quotes from third party sources. It currently has support for the Kanye Rest Api at https://api.kanye.rest/ API.

It has its own api endpoints for the following

**API Endpoints**: 
  - `GET /api/quotes`: Get a list of quotes.
  - `GET /api/quotes/refresh`: Refresh the cached quotes and receive new quotes.


**Notes**: 
- Has a Scheduled Job that runs nightly to store the quotes
- A Quote model does exist, but not in use. 

## Setup

To get started with the Laravel Quoter application, follow these steps:

### 1. Clone the Repository
```bash
git clone git@github.com:stowe-dev/laravel-quoter-dev.git    
```

### 2. Run the setup commands
```bash 
cd laravel-quoter-dev
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run build
```

### 3. Serve the application

If you are using Laravel Herd or a similar tool, you can visit your site now and see a simple Vue.js application demonstrating calls to the API.

Otherwise, you can run

```bash 
php artisan serve
```

and visit localhost:8000 in your browser, 

## API & Authorization

To use the API, you can use any HTTP client to hit the API endpoints, e.g., http://localhost:8000/api/quotes.

However, you must pass an Authorization header with your token to access the API.

By default, your API token/key will be your-api-token, which can be changed in your .env file if needed.

You can see how the Vue.js application handles this in resources/js/bootstrap.js:

```bash
`window.axios.defaults.headers.common['Authorization'] = `your-api-token`;
```

## Testing

The application has a number of tests and can be ran by running

```bash
php artisan test
```