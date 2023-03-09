<!DOCTYPE html>
<html>
<head>
    <title>gciwatch</title>
</head>
<body>
  @php
  $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
  @endphp
  <p>Inquiry received:</p><br />
    <p>
      User : {{auth()->user()->name}}  Time : {{  $date->format('H:i:s') }} Data : {{  $date->format('m/d/Y') }}
    </p>
    <p>
      IP Address: {{$userIp}}
    </p>
    <p> Company name : {{ $comapny }} </p>
    <p>Reference :{{ $reference}}</p>
    <p>Contact name : {{ $contact_name}}</p>
    <p>Email Address :{{ $email}}</p>
    <p>Contact Number : {{$contact_number}}</p>
    <p>Message : {{$question}}</p>
    <p>Product stock Number : {{$productstock}}</p>
    <p>Product Name : {{$productname}}</p>
    <p>Model Number : {{$productmodel}}</p>

</body>
</html>
