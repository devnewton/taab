<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="robots" content="noindex,nofollow">
        <title>taab</title>
        <link rel="stylesheet" href="css/blaze.css">
    </head>
    <body class="c-text">
        Login to taab...
    </body>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var token = new URL(window.location.href).hash.substr(1);
            if (token) {
                localStorage.token = token;
                window.location = "/";
            } else {
                document.getElementsByTagName("body")[0].innerText = "Cannot find login token :-(";
            }
        });
    </script>
</html>
