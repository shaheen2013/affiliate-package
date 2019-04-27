<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>
<body>
    <h4>New user send a affiliate request on your site {{ env('SITE_NAME') }}</h4>
    <p>User Details showing below:</p><br>
    <table border="1" cellpadding="5" cellspacing="0" style="width:100%">
        <tr>
            <th>Name</th>
            <th>:</th>
            <td>{{ $user->name.' '.$user->last_name }} $user->email, </td>
        </tr>
        <tr>
            <th>Email</th>
            <th>:</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>Promotion Message</th>
            <th>:</th>
            <td>{{ $aff->promotion_message }}</td>
        </tr>
        <tr>
            <th>Website URL</th>
            <th>:</th>
            <td>{{ $aff->website_url }}</td>
        </tr>
    </table>
</body>
</html>
