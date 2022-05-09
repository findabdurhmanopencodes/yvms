<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('/img/logo_peace.png') }}" class="logo" alt="National Youth Volunteerism">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
