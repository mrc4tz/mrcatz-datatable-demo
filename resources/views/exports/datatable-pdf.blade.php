<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><style>body{font-family:sans-serif;font-size:12px}table{width:100%;border-collapse:collapse}th,td{border:1px solid #ddd;padding:6px 8px;text-align:left}th{background:#1B3A5C;color:#fff}</style></head>
<body>
<h2>{{ $title }}</h2>
<p style="color:#888;font-size:10px">Exported: {{ now()->format('d M Y H:i') }}</p>
<table>
    <thead><tr>@foreach($headers as $h)<th>{{ $h }}</th>@endforeach</tr></thead>
    <tbody>@foreach($rows as $row)<tr>@foreach($row as $cell)<td>{{ $cell }}</td>@endforeach</tr>@endforeach</tbody>
</table>
<p style="color:#888;font-size:10px;margin-top:10px">Total: {{ count($rows) }} records</p>
</body>
</html>
