<!DOCTYPE html>
<html>
<head>
    <title>New Support Request</title>
</head>
<body style="font-family: 'Instrument Sans', sans-serif; line-height: 1.6; color: #333;">
    <h2>New Contact Form Submission</h2>
    <p><strong>Name:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <br>
    <p><strong>Message:</strong></p>
    <p style="white-space: pre-wrap;">{{ $data['message'] }}</p>
</body>
</html>