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
        table td {
            vertical-align: middle !important;
        }

        .narrow {
            width: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="mt-5">
        <label class="form-label" for="login">Login</label>
        <input id="login" class="form-control" name="login" type="text"/>
    </div>

    <div class="mt-3">
        <label class="form-label" for="password">Password</label>
        <input id="password" class="form-control" name="password" type="password"/>
    </div>

    <div class="mt-3">
        <button onclick="login()" class="btn btn-primary">Login</button>
    </div>
</div>

<script>
    function getCookie(name) {
        let results = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');

        if (results) {
            return (unescape(results[2]));
        }

        return null;
    }

    async function login() {
        await fetch('/sanctum/csrf-cookie', {
            method: 'GET', // *GET, POST, PUT, DELETE, etc.
            mode: 'cors', // no-cors, *cors, same-origin
            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
            credentials: 'same-origin', // include, *same-origin, omit
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            redirect: 'manual', // manual, *follow, error
            referrerPolicy: 'no-referrer', // no-referrer, *client
        });

        let response = await fetch('/login', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-XSRF-TOKEN': getCookie('XSRF-TOKEN'),
            },
            redirect: 'follow',
            referrerPolicy: 'no-referrer',
            body: JSON.stringify({
                'email': document.getElementById('login').value,
                'password': document.getElementById('password').value,
            }),
        });

        let result = await response.json();

        if(result.data.success) {
            location.href = '/';
        } else {
            alert('Авторизация не удалась');
        }
    }

</script>
</body>
</html>
