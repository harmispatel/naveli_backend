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
        <th>Total Active Users - {{ $totalActiveUsers }} </th>
    </tr>

    <tr>
        <td>Male</td>
        <td> {{ $totalMaleActiveUsers }} </td>
    </tr>

    <tr>
        <td>Female</td>
        <td> {{ $totalFemaleActiveUsers }} </td> 
    </tr>

    <tr>
        <td>Trans</td>
        <td> {{ $totalTransActiveUsers }} </td>  
    </tr>
</table>
