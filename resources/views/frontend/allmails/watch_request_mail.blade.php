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
      <h3> Request  watch  </h3>
    <table class="mi_daily_report">
      <thead>
      </thead>
      <tbody>
        
        <tr>
          <td>Name :</td>
          <td>
          {{$name}}
          </td>
        </tr>
        <tr>
          <td>Telephonr Number :</td>
          <td>
          {{$phone}}
          </td>
        </tr>
        <tr>
          <td>Model Number:</td>
          <td>
          {{$model}}
          </td>
        </tr>
        <tr>
          <td>Email :</td>
          <td>
          {{$email}}
          </td>
        </tr>
        <tr>
          <td>Dial :</td>
          <td>
          {{$dial}}
          </td>
        </tr>
        <tr>
          <td>Bezel :</td>
          <td>
          {{$bezel}}
          </td>
        </tr>
        <tr>
          <td>Band :</td>
          <td>
          {{$band}}
          </td>
        </tr>
        <tr>
          <td>Looking Price :</td>
          <td>
            {{$price}}
          </td>
        </tr>
        <tr>
          <td>Notes :</td>
          <td>
          {{$description}}
          </td>
        </tr>
    
      </tbody>
    </table>

  </body>
</html>
