<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <title>Fran Lara CV API</title> @vite('resources/css/api.css')
</head>
<body class="bgHome">
<div id="welcome" class="welcome"></div>
<script>
    {!! Vite::content('resources/js/api.js') !!}
    setWelcomeMessage('{{__('home.messages.welcome')}}');
</script>
</body>
</html>
