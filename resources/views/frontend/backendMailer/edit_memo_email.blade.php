<!DOCTYPE html>
<html>
<head>
    <title>gciwatch</title>
</head>
<body>
  @php
  $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
  @endphp
  <p>Memo Status Edited</p><br />
  @if($csName != "")
  <p>Company Name: <span>{{$csName->company}}</span></p><br />
  @endif
    <p>
      User : {{auth()->user()->name}} Updated Time : {{  $date->format('H:i:s') }} Data : {{  $date->format('m/d/Y') }}
    </p>
    <p>
      IP Address: {{$userIp}}
    </p>
    <p>{{$LsProAct}}  {{  $date->format('m/d/Y') }}</p>

</body>
</html>
