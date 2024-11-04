<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Sigmaniaga</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container text-center mt-5">
        <h1>Welcome to the Sigmaniaga Application!</h1>
        <p class="lead">Manage your transactions easily and efficiently.</p>
        
        <div class="mt-4">
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
            <a href="{{ route('register') }}" class="btn btn-success">Register</a>
        </div>

        <h2 class="mt-5">About Sigmaniaga</h2>
        <p>
            Sigmaniaga is designed to streamline your transaction management, providing insights into your sales and helping you make informed decisions. Whether you're a small business or managing large volumes, our application is tailored to meet your needs with ease of use and powerful features.
        </p>
    </div>
</body>
</html>
