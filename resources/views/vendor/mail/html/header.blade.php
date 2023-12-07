@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ Vite::asset('resources/images/logo.png') }}">
@else
{{ $slot }}
<img src="{{ Vite::asset('resources/images/logo.png') }}">
@endif
</a>
</td>
</tr>
