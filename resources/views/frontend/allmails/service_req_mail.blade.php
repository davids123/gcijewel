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
      <h3>Service Request  Notification</h3>
    <table class="mi_daily_report">
      <thead>
      </thead>
      <tbody>
        <tr>
          <td>Company :</td>
          <td>
          {{$company}}
          </td>
        </tr>
        <tr>
          <td>Name :</td>
          <td>
          {{$name}}
          </td>
        </tr>
        <tr>
          <td>Email :</td>
          <td>
          {{$email}}
          </td>
        </tr>
        <tr>
          <td>Phone :</td>
          <td>
          {{$phone}}
          </td>
        </tr>
        <tr>
          <td>Address :</td>
          <td>
          {{$address}}
          </td>
        </tr>
        <tr>
          <td>City :</td>
          <td>
          {{$city}}
          </td>
        </tr>
        <tr>
          <td>State :</td>
          <td>
          {{$state}}
          </td>
        </tr>
        <tr>
          <td>Zip :</td>
          <td>
          {{$zip}}
          </td>
        </tr>
        <tr>
          <td>Brand :</td>
          <td>
            {{$brand}}
          </td>
        </tr>
        <tr>
          <td>Serial :</td>
          <td>
          {{$serial}}
          </td>
        </tr>
        <tr>
          <td>Model :</td>
          <td>
          {{$model}}
          </td>
        </tr>
        <tr>
          <td>Description :</td>
          <td>
          {{$description}}
          </td>
        </tr>
      </tbody>
    </table>

  </body>
</html>
