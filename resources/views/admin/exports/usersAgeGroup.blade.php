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
