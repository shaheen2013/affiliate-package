<!DOCTYPE html>
<html>
<head>
    <title>Welcome Email</title>
</head>
<body>
    <h4>New user register on your site {{ env('APP_NAME') }}</h4>
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
            <th>Phone</th>
            <th>:</th>
            <td>{{ $user->phone }}</td>
        </tr>
    </table>
</body>
</html>
