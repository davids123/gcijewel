<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style media="screen">

      .mi_daily_report tr th, .mi_daily_report tr td{
        /*border:1px solid #000;*/
        padding: 5px;
        font-weight: bold;
        font-size: 14px;
      }
      .mi_daily_report tr th{
        font-size: 18px;
      }

    </style>
  </head>
  <body>
      <h3> Sell My Watch Notification</h3>
    <table class="mi_daily_report">
      <thead>
      </thead>
      <tbody>
        <tr>
          <td>First Name :</td>
          <td>
          {{$first_name}}
          </td>
        </tr>
        <tr>
          <td>Last Name :</td>
          <td>
          {{$last_name}}
          </td>
        </tr>
        <tr>
        <tr>
          <td>Email :</td>
          <td>
            {{$email}}
          </td>
        </tr>
        <tr>
          <td>Watch Brand :</td>
          <td>
          {{$watch_brand}}
          </td>
        </tr>
        <tr>
          <td>Amount :</td>
          <td>
          ${{$amount}}
          </td>
        </tr>
        <tr>
          <td>Box Paper :</td>
          <td>
          {{$box_paper}}
          </td>
        </tr>
        <tr>
          <td>Model Number :</td>
          <td>
          {{$model_number}}
          </td>
        </tr>
        <tr>
          <td>Comment:</td>
          <td>
          {{$comment}}
          </td>
        </tr>
      </tbody>
    </table>

  </body>
</html>
