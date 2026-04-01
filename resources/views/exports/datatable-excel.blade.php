<table>
    <thead><tr>@foreach($headers as $h)<th><strong>{{ $h }}</strong></th>@endforeach</tr></thead>
    <tbody>@foreach($rows as $row)<tr>@foreach($row as $cell)<td>{{ $cell }}</td>@endforeach</tr>@endforeach</tbody>
</table>
