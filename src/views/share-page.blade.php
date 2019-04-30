<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
</head>
<body>
    <img src="{{url('images/affiliateBanners/'.$affiliate->activeBanner->banner_image)}}" alt="{{$affiliate->activeBanner->banner_heading}}">

    <script>
        window.location.href = '{{url('i/'.$affiliate->affiliate_code.'/'.$affiliate->user_code)}}';
    </script>
</body>
</html>
