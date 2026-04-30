<table border="1">
<tr>
    <th>Judul</th>
    <th>Tahun</th>
</tr>

@foreach($movies as $movie)
<tr>
    <td>{{ $movie->judul }}</td>
    <td>{{ $movie->tahun }}</td>
</tr>
@endforeach

</table>
