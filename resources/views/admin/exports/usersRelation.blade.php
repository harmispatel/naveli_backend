<table>
    <tr>
        <th>From</th>
        <th>To</th>
    </tr>

    <tr>
        <td> {{ $startDate }}</td>
        <td>{{ $endDate }}</td>
    </tr>

    <tr></tr>
    
    <tr>
        <th>Total Users (Relation Wise) - {{ $total }}</th>
    </tr>

    <tr>
        <td>Solo</td>
        <td> {{ $total_solo }} </td>
    </tr>

    <tr>
        <td>Tied</td>
        <td> {{ $total_tied }} </td> 
    </tr>

    <tr>
        <td>OFS</td>
        <td> {{ $total_ofs }} </td>  
    </tr>
</table>
