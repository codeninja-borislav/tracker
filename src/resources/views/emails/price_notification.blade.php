<!DOCTYPE html>
<html>
<head>
    <title>Price Notification</title>
</head>
<body>
<h1>Price Alert</h1>
<p>Hello,</p>
<p>The price for {{ $subscription->currency_pair->value }} has triggered a notification:</p>
<ul>
    <li>Type: {{ $notification->notification_type->name }}</li>
    <li>Current Price: {{ $currentPrice->lastPrice }}</li>
</ul>
</body>
</html>
