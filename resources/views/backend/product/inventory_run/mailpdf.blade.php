<!DOCTYPE html>
<html>
<head>
    <title>gciwatch</title>
    <style>
    @media print {
  .table-striped{
    width: 100%;
  }
  table.table-striped{
      border-collapse: collapse;
      margin-top:0px;
  }
  .table-striped tr th, .table-striped tr td{
    padding: 10px;
    text-align: center;
    font-size: 14px !important;
    vertical-align:top;
    font-weight: normal !important;
    border:1px solid #000 !important;
  }
  /*.mi_inv_pdf tr td.stock_id{*/
  /*  width: 50%;*/
  /*}*/
    }
  
    </style>
</head>
<body>

<div class="modal-header">
	<!--<img src="https://gcijewel.com/public/uploads/all/O2yCFLQfu0nitWXPCfza2pYto0xjo8kqGbfusjON.png" class="img-fluid w-25 logo-rem">-->
    <!-- <h5 class="modal-title">Return Items</h5> -->
    @php
         $stockId=explode(',',$stockId);
        $stockId=implode(' , ', $stockId);
        
          $missing=explode(',',$missing);
        $missing=implode(' , ', $missing);
        
          $duplicate=explode(',',$duplicate);
        $duplicate=implode(' , ', $duplicate);
        
          $extra=explode(',',$extra);
        $extra=implode(' , ', $extra);
    @endphp
    <table class='table table-bordered  table-striped  order-table '>
        <thead>
            <tr>
                  <th>Listing Types :</th>
                  <th> {{$lsType}}</th>
            </tr>
        </thead>
        <tbody>
            
            <tr>
                  <td>Missing </td>
                  <td>{{$missing}} </td>
                  
            </tr>
            <tr>
              <td>Duplicate </td>
              <td>{{$duplicate}} </td>
            </tr>
            <tr>
                  <td>Extra </td>
                  <td>{{$extra}} </td>
            </tr>
            <tr>
                  <td>Date </td>
                  <td>{{$date}} </td>
            </tr>
            <tr>
                  <td>Warehouse </td>
                  <td>{{$warehouse }}</td>
            </tr>
            <tr>
                  <td>Stock Id </td>
                  <td> {{$stockId }} , {{$extra }}</td>
            </tr>
            <tr>
                  <td>Address </td>
                  <td>{{$address }}</td>
            </tr>
        </tbody>
         <tfoot>
         </tfoot>
    </table>
</div>
 

</body>
</html>
