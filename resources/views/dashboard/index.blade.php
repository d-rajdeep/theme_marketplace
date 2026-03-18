<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard – Themeour</title>
</head>

<body>

    <h1>Welcome, {{ Auth::user()->name }}!</h1>
    <p>You are logged in.</p>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>

</body>

</html>
