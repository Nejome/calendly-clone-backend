<!DOCTYPE html>
<html>
<head>
    <title>Event Reminder</title>
</head>
<body>
<p>Hi {{$data['name']}},</p>

<p>This is a reminder for newly created or an exist event.</p>

<p>
    <strong>Event Type:</strong><br>
    {{$data['event_type']}}
</p>

<p>
    <strong>With:</strong><br>
    {{$data['with_name']}}
</p>

<p>
    <strong>Email:</strong><br>
    {{$data['with_email']}}
</p>

<p>
    <strong>Date/Time:</strong><br>
    {{$data['date_time']}}
</p>

<a href="{{$data['join_link']}}">Join Link</a>

<p>
    <strong>Password:</strong><br>
    {{$data['password']}}
</p>

<p>Thanks</p>
</body>
</html>
