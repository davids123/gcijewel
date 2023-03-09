<!DOCTYPE html>
<html>
<head>
    <title>gciwatch</title>
</head>
<body>
  @php
  $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
  @endphp
  <p>Job-order Edited</p><br />
    <p>
      User : {{auth()->user()->name}} Edited {{$stock_id}} Time : {{  $date->format('H:i:s') }} Data : {{  $date->format('m/d/Y') }}
    </p>
    <p>
      IP Address: {{$userIp}}
    </p>
    @php 
        $allagent=App\Agent::findOrFail($new_agent);
        $newAgent=$allagent->first_name;
        $oldbagNumber = $jo_order_detail->bag_number;
        $oldlistingType=$jo_order_detail->item_type;
        $oldStockId=$jo_order_detail->stock_id;
        $oldmodelN=$jo_order_detail->model_number;
        $oldSerialN=$jo_order_detail->serial_number;
        $oldWeight=$jo_order_detail->weight;
        $oldscrew_count=$jo_order_detail->screw_count;
        $olddateforwarded=$jo_order_detail->date_forwarded;
        $oldagent=$jo_order_detail->first_name;
        
    @endphp
    @if($new_bag_number != $oldbagNumber)
        <p> Updated Fields such as Bag number From {{$oldbagNumber}} To {{$new_bag_number }} by {{auth()->user()->name}} Data : {{  $date->format('m/d/Y') }} </p>
    @endif
     @if($new_listing_type != $oldlistingType)
        <p> Updated Fields such as Listing Type From {{$oldlistingType}} To {{$new_listing_type }} by {{auth()->user()->name}} Data : {{  $date->format('m/d/Y') }} </p>
    @endif
     @if($new_stock_id != $oldStockId)
        <p> Updated Fields such as Stock Id From {{$oldStockId}} To {{$new_stock_id }} by {{auth()->user()->name}} Data : {{  $date->format('m/d/Y') }} </p>
    @endif
     @if($new_model_n != $oldmodelN)
        <p> Updated Fields such as Model Number From {{$oldmodelN}} To {{$new_model_n }} by {{auth()->user()->name}} Data : {{  $date->format('m/d/Y') }} </p>
    @endif
     @if($new_serial_n != $oldSerialN)
        <p> Updated Fields such as Serial Number From {{$oldSerialN}} To {{$new_serial_n }} by {{auth()->user()->name}} Data : {{  $date->format('m/d/Y') }} </p>
    @endif
     @if($new_weight != $oldWeight)
        <p> Updated Fields such as Weight From {{$oldWeight}} To {{$new_weight }} by {{auth()->user()->name}} Data : {{  $date->format('m/d/Y') }} </p>
    @endif
     @if($new_screw_count != $oldscrew_count)
        <p> Updated Fields such as Screw count From {{$oldscrew_count}} To {{$new_screw_count }} by {{auth()->user()->name}} Data : {{  $date->format('m/d/Y') }} </p>
    @endif
     @if($new_Date_f != $olddateforwarded)
        <p> Updated Fields such as Date Forwarded From {{$olddateforwarded}} To {{$new_Date_f }} by {{auth()->user()->name}} Data : {{  $date->format('m/d/Y') }} </p>
    @endif
     @if($newAgent != $oldagent)
        <p> Updated Fields such as Agent From {{$oldagent}} To {{$newAgent}} by {{auth()->user()->name}} Data : {{  $date->format('m/d/Y') }} </p>
    @endif
    
   
</body>
</html>
