@extends('frontend.layouts.app')
@section('content')





<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Form</title>
    <style>
        .container {
            width: 100%;
        }

        .title {
            font-style: normal;
            font-size: 20px;

            font-family: sans-serif;
        }

        label {
            font-size: 16px;
            font-family: cursive;
        }

        .star {
            color: red;
        }

        input#name {
            width: 464px;
            border: 1px solid rgb(58, 49, 49);
            border-radius: 3px;
            padding: 7px;
            background-color: #fff;

        }

        input#submit {
            width: 78px;
            color: white;
            font-family: sans-serif;
            font-size: 18px;
            padding: 6px;
            cursor: pointer;
            border: 0px solid black;
            background-color: #1287eb;
            margin-left: 295px;

        }

        input#colse {
            width: 78px;
            padding: 5px;
            font-family: sans-serif;
            font-size: 18px;
            margin-left: 8px;
            cursor: pointer;
            border: 1px solid black;
            background-color: #f3f3f3;

        }

        .modal-body {
            padding: 0rem;
        }
    </style>
</head>

<body>
    <!-- Button trigger modal -->
    <a type="button" style="cursor: pointer" data-toggle="modal" data-target="#exampleModal">
REQUEST A WATCH
    </a>

    @if(session('status'))
    <div class="alert alert-success">{{session('status')}}</div>

    @endif

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <h5 class="modal-title" id="exampleModalLabel">Form</h5> --}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">



                        <div class="title">REQUEST A WATCH</div>
                        <hr>
                        <form action="{{url('add')}}" id="register" method="post">
                            @csrf
                            <label><span class="star">*</span>Name**</label>
                            <br>
                            <input type="text" name="name" id="name">
                            <br>
                            <label><span class="star">*</span>Telephone Number**</label>
                            <br>
                            <input type="number" name="Telephone" id="name">
                            <br>
                            <label><span class="star">*</span>Model Number**</label>
                            <br>
                            <input type="number" name="model" id="name">
                            <br>
                            <label><span class="star">*</span>Email**</label>
                            <br>
                            <input type="email" name="email" id="name">
                            <br>
                            <label><span class="star">*</span>Dial**</label>
                            <br>
                            <input type="text" name="dial" id="name">
                            <br>
                            <label><span class="star">*</span>Bezel**</label>
                            <br>
                            <input type="text" name="bezel" id="name">
                            <br>
                            <label><span class="star">*</span>Band**</label>
                            <br>
                            <input type="text" name="band" id="name">
                            <br>
                            <label><span class="star">*</span>Looking Price**</label>
                            <br>
                            <input type="text" name="looking_price" id="name">
                            <br>
                            <label><span class="star">*</span>Notes**</label>
                            <br>
                            <textarea name="notes" id="notes" cols="60" rows="2"></textarea>
                            <br><br>
                            <input type="submit" value="Submit" id="submit">
                            {{-- <input type="submit"> --}}
                            <input type="button" value="Close" id="colse">
                            <br><br>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>



























@endsection