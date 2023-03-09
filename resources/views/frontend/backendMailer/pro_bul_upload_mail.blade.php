<!DOCTYPE html>
<html>
<head>
    <title>gciwatch</title>
</head>
<body>
  @php
  $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
  $time=$date->format('H:i:s') ;
  @endphp
  <p>Product Bulk Import</p><br />
    <p>
      User : {{auth()->user()->name}} Imported Bulk Products Time :{{date("g:i A", strtotime($time))}}  Data : {{  $date->format('m/d/Y') }}
    </p>
    <p>
      IP Address: {{$userIp}}
    </p>

</body>
</html>
