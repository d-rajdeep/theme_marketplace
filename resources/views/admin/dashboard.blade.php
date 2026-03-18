<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard – Themeour</title>
</head>

<body>

    <h1>Admin Dashboard</h1>

    <ul>
        <li>Total Users: {{ $stats['total_users'] }}</li>
        <li>Total Products: {{ $stats['total_products'] }}</li>
        <li>Total Orders: {{ $stats['total_orders'] }}</li>
        <li>Total Revenue: ₹{{ number_format($stats['total_revenue'], 2) }}</li>
        <li>Total Categories: {{ $stats['total_categories'] }}</li>
    </ul>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>

</body>

</html>
