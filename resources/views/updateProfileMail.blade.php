<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $data['title'] }}</title>
</head>
<body>
    <table class="table">
          <tr>
            <th scope="col">Name</th>
            <th scope="col">{{ $data['name'] }}</th>
          </tr>
          <tr>
            <th scope="col">Email</th>
            <th scope="col">{{ $data['email'] }}</th>
          </tr>
          <tr>
            <th scope="col">Your New Password</th>
            <th scope="col"><p>@isset($data['password']){{ $data['password'] }}@endisset</p></th>
          </tr>
      </table>

      <a href="{{ $data['url'] }}">Click here to login your account!</a>
      <p>Thank You!</p>
</body>
</html>
