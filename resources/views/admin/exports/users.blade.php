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
        <th>Total Users (Gender Wise)</th>
    </tr>

    <tr>
        <td>Male</td>
        <td> {{ $totalMale }} </td>
    </tr>

    <tr>
        <td>Female</td>
        <td> {{ $totalFemale }} </td>
    </tr>

    <tr>
        <td>Transgender</td>
        <td> {{ $totalTrans }} </td>
    </tr>

    <tr></tr>
    <tr>
        <th>Total Users (Relation Wise)</th>
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
      
    <tr></tr>

    <tr>
        <td colspan="6">AgeGroups - {{ $ageGroupName }} - {{ $totalAgeGroupCount }}</td>
    </tr>
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
        <td>{{ $ageExploreTrans }} </td>
    </tr>

    
</table>
