<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Users | Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>
</head>
<body class="antialiased">
<ul>
    @foreach ($users as $user)
        <li>{{ $user->last_name }}, {{ $user->first_name }}</li>
    @endforeach

    @if($links['prev_page'] !== null)
        <a href="/users?page={{$links['prev_page']}}">Previous</a>
    @endif

    @if($links['next_page'] !== null)
        <a href="/users?page={{$links['next_page']}}">Next</a>
    @endif
</ul>
</body>
</html>