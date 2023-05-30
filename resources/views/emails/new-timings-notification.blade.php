<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Order Timings Notification</title>
</head>
<body>
    <div style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
        <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border: 1px solid #dddddd;">
            <h1 style="font-size: 24px; margin-top: 0;">Action Required: Modified Order Start and End Time</h1>
            <p style="font-size: 16px;">Dear employee,</p>
            <p style="font-size: 16px;">We would like to inform you that there have been updates to the order timings:</p>
            <div style="margin-bottom: 20px;">
                <strong style="font-size: 16px;">Start Time:</strong>
                <p style="font-size: 16px;">{{ $time_setting->order_start_time }}</p>
            </div>
            <div>
                <strong style="font-size: 16px;">End Time:</strong>
                <p style="font-size: 16px;">{{ $time_setting->order_end_time }}</p>
            </div>
            <p style="font-size: 16px;">Please adjust your schedule accordingly.</p>
            <p style="font-size: 16px;">Regards,</p>
            <p style="font-size: 16px;">Onyxtec Admin</p>
        </div>
    </div>
</body>
</html>
