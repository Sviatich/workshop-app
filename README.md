# Workshop App

This repository contains a Laravel application using Livewire and Vite. The project lets you configure and order boxes through a web interface.

## Requirements

- PHP 8.2 or higher
- Node.js and npm
- Composer

## Setup

Install PHP and Node dependencies:

```bash
composer install
npm install && npm run build
```

Create your environment file and generate the application key:

```bash
cp .env.example .env && php artisan key:generate
```

Run the test suite to verify your installation:

```bash
./vendor/bin/pest --parallel
```

## Usage

After installing the dependencies and configuring the environment, start the local development server:

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser to access the application.

The application is a starter kit for building a configurator and ordering workflow using Laravel, Livewire and Tailwind CSS.

