<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('style.css?v=1')}}">
    <title>{{$title ?? 'Savers bank'}}</title>
</head>
<body>
@include('nav')
@include('msg.message')
@yield('content')
</body>
</html>