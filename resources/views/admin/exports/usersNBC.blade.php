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
        <td colspan="6">Total Users - {{ $totalUsers }}</td>
    </tr>

    <tr>
        <th colspan="2">Total Neow - {{ $totalNeow }} </th>
        <th colspan="2">Total Buddy - {{ $totalBuddy }} </th>
        <th colspan="2">Total CycleExplore - {{ $totalCycleExplore }} </th>
    </tr>
    <tr>
        <td>Female</td>
        <td>{{ $neowFemale }}</td>
        <td>Male</td>
        <td>{{ $buddyMale }} </td>
        <td>Male</td>
        <td>{{ $cycleExploreMale }} </td>
    </tr>

    <tr>
        <td>Transgender</td>
        <td>{{ $neowTrans }}</td>
        <td>Female</td>
        <td>{{ $buddyFemale }} </td>
        <td>Female</td>
        <td>{{ $cycleExploreFemale }} </td>
    </tr>

    <tr>
        <td></td>
        <td></td>
        <td>Transgender</td>
        <td>{{ $buddyTrans }} </td>
        <td>Transgender</td>
        <td>{{ $cycleExploreTrans }} </td>
    </tr>

    
</table>
