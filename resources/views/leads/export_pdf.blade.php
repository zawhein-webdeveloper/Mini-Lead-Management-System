<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Leads Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-new {
            color: #28a745;
        }
        .status-in-progress {
            color: #ffc107;
        }
        .status-closed {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <h1>Leads Report</h1>
    <p><strong>Generated on:</strong> {{ date('Y-m-d H:i:s') }}</p>
    <p><strong>Total Leads:</strong> {{ $leads->count() }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($leads as $lead)
            <tr>
                <td>{{ $lead->id }}</td>
                <td>{{ $lead->name }}</td>
                <td>{{ $lead->email }}</td>
                <td>{{ $lead->phone }}</td>
                <td class="status-{{ $lead->status }}">
                    {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                </td>
                <td>{{ $lead->created_at->format('Y-m-d H:i:s') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>