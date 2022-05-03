<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,
				initial-scale=1,
				shrink-to-fit=no">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('/images/favicon.png') }}" type="image/gif" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js">
    </script>
    <style>
        .bs-example {
            margin: 20px;
        }
    </style>
</head>

<body>
    <div class="bs-example">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 bg-light text-center">
                    <h1>Email Verified</h1>
                    <h2>You need Admin verification to login.</h2>
                    <h2><a href="{{url('/')}}">Go to HomePage</a>  !!
                    </h2>

                </div>
            </div>
        </div>
    </div>
</body>

</html>