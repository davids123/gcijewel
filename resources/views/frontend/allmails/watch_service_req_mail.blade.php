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
      <h3> Watch Service Notification</h3>
    <table class="mi_daily_report">
      <thead>
      </thead>
      <tbody>
        <tr>
          <td>Type :</td>
          <td>
          {{$type}}
          </td>
        </tr>
        <tr>
          <td>Job detail :</td>
          <td>
          {{$job_detail}}
          </td>
        </tr>
        <tr>
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
