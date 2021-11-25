# Lumen/ Laravel or OOP PHP coding challenge

Developed by Prabhashwara Chandrapadma (prab.ch@pm.me)

![Preview](https://i.imgur.com/jon3Nmt.png)

## Installation

Clone the repository

Execute following commands

```bash
composer install
php artisan key:generate
php artisan cache:clear
php artisan migrate
npm install && npm run dev
```
You are ready to use the application now !

## Features
* Authentication via Laravel/Sanctum
* Medium Integration over Intergration Token
* Fetching list of publications
* Creating and saving posts locally
* Submitting posts to Medium as drafts

## Technologies Used
* Laravel 8.73.2
* Vue JS 3.2.22

**Third-party plugins used**
* Materialize CSS 1.0
* Vue Toast Notification 2.0.1

## Issues faced

* **Authenticate with Medium OAuth** : Medium no longer allow OAuth connections, Instead used Integration Tokens as described in the [developer documentation](https://github.com/Medium/medium-api-docs)