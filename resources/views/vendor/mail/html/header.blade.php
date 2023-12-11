@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
{{ $slot }}
<img src="$logo" class="logo">
</a>
</td>
</tr>
