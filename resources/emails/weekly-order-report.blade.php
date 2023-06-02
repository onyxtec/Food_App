<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Weekly Order History</title>
</head>
<body>
    @php
    @endphp
    <div style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
        <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border: 1px solid #dddddd;">
            <h3 style="font-size: 24px; margin-top: 0;">{{ $order->user }}</h3>
            <p style="font-size: 16px;">Dear employee,</p>
            <p style="font-size: 16px;">We would like to inform you that there have been updates to the order timings:</p>
            {{-- <div style="margin-bottom: 20px;">
                <strong style="font-size: 16px;">Start Time:</strong>
                <p style="font-size: 16px;">{{ $start_time_in_12Hour }}</p>
            </div>
            <div>
                <strong style="font-size: 16px;">End Time:</strong>
                <p style="font-size: 16px;">{{  $end_time_in_12Hour }}</p>
            </div> --}}
            <p style="font-size: 16px;">Please adjust your schedule accordingly.</p>
            <p style="font-size: 16px;">Regards,</p>
            <p style="font-size: 16px;">Onyxtec Admin</p>
        </div>
    </div>
</body>
</html>
