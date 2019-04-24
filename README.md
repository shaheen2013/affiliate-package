# Laravel User Affiliate

[![Build Status](https://travis-ci.org/hootlex/laravel-friendships.svg?branch=v1.0.21)](https://travis-ci.org/hootlex/laravel-friendships) [![Code Climate](https://codeclimate.com/github/hootlex/laravel-friendships/badges/gpa.svg)](https://codeclimate.com/github/hootlex/laravel-friendships) [![Test Coverage](https://codeclimate.com/github/hootlex/laravel-friendships/badges/coverage.svg)](https://codeclimate.com/github/hootlex/laravel-friendships/coverage) [![Total Downloads](https://img.shields.io/packagist/dt/hootlex/laravel-friendships.svg?style=flat)](https://packagist.org/packages/hootlex/laravel-friendships) [![Version](https://img.shields.io/packagist/v/hootlex/laravel-friendships.svg?style=flat)](https://packagist.org/packages/hootlex/laravel-friendships) [![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat)](LICENSE) [![Join the chat at https://gitter.im/laravel-friendships/Lobby](https://badges.gitter.im/laravel-friendships/Lobby.svg)](https://gitter.im/laravel-friendships/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

## This is not ready project

This package provides user wise affiliate program.

## Models can:
- Request for affiliate
- Admin Accept/Deny Requests
- Commission based affiliate
- User affiliate dashboard

## Installation

First, install the package through Composer.

```php
composer require mediusware/affiliate
```

If you are using Laravel < 5.5, you need to add Mediusware\Affiliate\AffiliateServiceProvider to your `config/app.php` providers array:
```php
Mediusware\Affiliate\AffiliateServiceProvider::class,
```
Publish config and migrations
```
php artisan vendor:publish --provider="Mediusware\Affiliate\AffiliateServiceProvider"
```
Configure the published config in
```
config\affiliate.php
```
Finally, migrate the database
```
php artisan migrate
```