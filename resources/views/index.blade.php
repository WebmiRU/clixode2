<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clixode user area</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-CuOF+2SnTUfTwSZjCXf01h7uYhfOBuxIhGKPbfEJ3+FqH/s6cIFN9bGr1HmAg4fQ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-popRpmFF9JQgExhfw5tZT4I9/CI5e2QcuUZPOVXb1m7qUmeR2b50u+YFEYe1wgzy"
            crossorigin="anonymous"></script>

    <style>
        .body {
            display: grid;
            grid-template-columns: 300px 1fr;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="body">
        <div class="menu">
            <ul>
                <li>
                    <a href="{{route('bucket.index')}}">Buckets</a>
                </li>
            </ul>
        </div>
        <div class="content">
            @section('content')
                <h1>Content body</h1>
            @show
        </div>
    </div>
</div>

</body>
</html>
