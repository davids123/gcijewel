<!DOCTYPE html>
<html>
<head>
    <title>gciwatch</title>
</head>
<body>
  @php
  $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
  echo $date;
  @endphp
  <p>Product Edited</p><br />
    <p>
      User : {{auth()->user()->name}} Edited {{$stock_id}} Time : {{  $date->format('H:i:s') }} Data : {{  $date->format('m/d/Y') }}
    </p>
    <p>
      IP Address: {{$userIp}}
    </p>
    @foreach ($LsProAct as $PActval)
      <p>{{$PActval}} {{  $date->format('m/d/Y') }}</p>
    @endforeach


</body>
</html>
