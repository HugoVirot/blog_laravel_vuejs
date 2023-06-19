<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Blog Laravel VueJS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/6259f9b52f.js" crossorigin="anonymous"></script>

    <!-- Script Vite : pour compiler et utiliser les fichiers css et js -->
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body>
    <div id="app"></div>
</body>

</html>
