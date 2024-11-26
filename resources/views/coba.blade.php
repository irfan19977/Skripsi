<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User QR Code</title>
</head>
<body>
    <h1>QR Code for {{ $user->name }}</h1>
    
    @if (session('qrCode'))
        <div>
            {!! session('qrCode') !!}
        </div>
    @else
        <p>No QR Code available</p>
    @endif
</body>
</html>
