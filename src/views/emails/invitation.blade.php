<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>
<body>
    <h4>Hello,</h4>
    <p>{{Auth::user()->name.' '.Auth::user()->last_name}} has been invited you to join {{ env('APP_NAME') }}</p>
    <p><a href="{{ env('APP_URL').'/i/'.$affiliate->affiliate_code.'/'.$affiliate->user_code }}">Click here</a> to signup or copy this link then paste in browser url addressbar and hit enter<br>{{ env('APP_URL').'/i/'.$affiliate->affiliate_code.'/'.$affiliate->user_code }}<br><br>

    {!! nl2br($request->custom_message) !!}
</body>
</html>
