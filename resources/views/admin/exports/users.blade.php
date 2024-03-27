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

    <tr></tr>
    <tr>
        <th colspan="2">Total Users (GenderWise)</th>
        <th colspan="2">Total Users(Relation Wise)</th>
    </tr>

    <tr>
        <td>Male</td>
        <td> {{ $totalMale }} </td>
        <td>Solo</td>
        <td> {{ $total_solo }} </td>
    </tr>

    <tr>
        <td>Female</td>
        <td> {{ $totalFemale }} </td>
        <td>Tied</td>
        <td> {{ $total_tied }} </td> 
    </tr>

    <tr>
        <td>Transgender</td>
        <td> {{ $totalTrans }} </td>
        <td>OFS</td>
        <td> {{ $total_ofs }} </td>  
    </tr>
       
    <tr></tr>

    <tr>
        <th>Age Groups</th>
    </tr>

    <tr>
        <td>{{ $ageGroupName }}</td>
        <td></td>
    </tr>

    <tr></tr>
    <tr>
        <th colspan="2">Total Neow - {{ $ageTotalNeow }} </th>
        <th colspan="2">Total Buddy - {{ $ageTotalBuddy }} </th>
        <th colspan="2">Total CycleExplore - {{ $ageTotalExplore }} </th>
    </tr>
    <tr>
        <td>Female</td>
        <td>{{ $ageNeowFemale }}</td>
        <td>Male</td>
        <td>{{ $ageBuddyMale }} </td>
        <td>Male</td>
        <td>{{ $ageExploreMale }} </td>
    </tr>

    <tr>
        <td>Transgender</td>
        <td>{{ $ageNeowTrans }}</td>
        <td>Female</td>
        <td>{{ $ageBuddyFemale }} </td>
        <td>Female</td>
        <td>{{ $ageExploreFemale }} </td>
    </tr>

    <tr>
        <td></td>
        <td></td>
        <td>Transgender</td>
        <td>{{ $ageBuddyTrans }} </td>
        <td>Transgender</td>
        <td>{{ $cycleExploreTrans }} </td>
    </tr>

    
</table>
