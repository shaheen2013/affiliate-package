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

## Setup Affiliate

User affiliate registration link (Add this in your website where you want to show link)
```
{{ url('affiliate') }}
or
<li><a class="nav-link" href="{{ url('affiliate') }}">Affiliate</a></li>
```

Add this in your user panel where you want to show user Affiliate link
```
<a class="dropdown-item" href="/affiliate/dashboard">Affiliate</a>
```

Add this in your admin master template navigation section
```
<li class="treeview {{_active(['affiliate','affiliate-request','affiliate-dashboard','affiliate-banner'])}}">
    <a href="#"><i class="fa-desktop"></i> <span>Affiliate</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{_active(['affiliate-dashboard'])}}"><a href="{!! url('admin/affiliate-dashboard') !!}"><i class="fa fa-circle-o"></i> </i>Dashboard</a></li>
        <li class="{{_active(['affiliate'])}}"><a href="{!! url('admin/affiliate') !!}"><i class="fa fa-circle-o"></i> </i>Affiliate Users</a></li>
        <li class="{{_active(['affiliate-request'])}}"><a href="{!! url('admin/affiliate-request/pending') !!}"><i class="fa fa-circle-o"></i> </i>Affiliate Request</a></li>
        <li class="{{_active(['affiliate-banner'])}}"><a href="{!! url('admin/affiliate-banner') !!}"><i class="fa fa-circle-o"></i> </i>Banner</a></li>
    </ul>
</li>
```

Add this in your views/layout/app.blade.php head section for Affiliate banner share
```
@if(isset($affiliate))
    @if(!empty($affiliate->activeBanner))
        <title>{{$affiliate->activeBanner->banner_heading}}</title>
        <meta name="description" content="{{$affiliate->activeBanner->banner_message}}">
        <meta name="keywords" content="{{$affiliate->activeBanner->banner_heading}}">
        <meta name="author" content="{{$affiliate->user->name}}">

        <meta property="og:title" content="{{$affiliate->activeBanner->banner_heading}}" />
        <meta property="og:url" content="{{url('i/'.$affiliate->affiliate_code.'/'.$affiliate->user_code)}}" />
        <meta property="og:image:type" content="image/jpeg" />
        <meta property="og:image" content="{{url('images/affiliateBanners/'.$affiliate->activeBanner->banner_image)}}" />
        <meta property="og:image:secure_url" content="{{url('images/affiliateBanners/'.$affiliate->activeBanner->banner_image)}}" />
        <meta property="og:image:width" content="400" />
        <meta property="og:image:height" content="300" />
        <meta property="og:image:alt" content="{{$affiliate->activeBanner->banner_heading}}" />
    @endif
@else
    <title>AIMSTAR.GG</title>
    <!-- Meta-Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="game">
@endif
```
