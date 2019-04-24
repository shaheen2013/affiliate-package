# Laravel User Affiliate

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
