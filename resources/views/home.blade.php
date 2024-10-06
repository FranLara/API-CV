<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Fran Lara CV API</title>
    @vite('resources/css/api.css')
</head>
<body class="bgHome">
<div><h1 class="name">Francisco Ildefonso Lara Casalilla</h1></div>
<div><span id="welcome" class="welcome"></span></div>
<script>
    {!! Vite::content('resources/js/api.js') !!}
    setWelcomeMessage('{{__('home.messages.welcome')}}');
</script>
<div class="social_networks">
    <span>{{__('home.messages.social_networks')}}</span>
    <ul>
        <li><a href="https://www.linkedin.com/in/franciscolaracasalilla/" target="_blank">LinkedIn</a></li>
        <li><a href="https://github.com/FranLara" target="_blank">GitHub</a></li>
        <li><a href="mailto:francisco.lara.casalilla@gmail.com">Email</a></li>
    </ul>
</div>
</body>
</html>