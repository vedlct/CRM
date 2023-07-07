<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Company Name</th>
        <th>Category</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($leads as $lead)
        <tr>
            <td>{{ $lead['Lead Id'] }}</td>
            <td>{{ $lead['Company Name'] }}</td>
            <td>{{ $lead['Category'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>