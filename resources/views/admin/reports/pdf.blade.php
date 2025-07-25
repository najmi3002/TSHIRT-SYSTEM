<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Business Report PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
        .kpi { margin-bottom: 20px; }
        .kpi span { display: inline-block; min-width: 180px; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Business Report</h2>
    <div class="kpi">
        <span>Start Date:</span> {{ $startDate->format('Y-m-d') }}<br>
        <span>End Date:</span> {{ $endDate->format('Y-m-d') }}<br>
        <span>Total Revenue:</span> RM{{ number_format($totalRevenue, 2) }}<br>
        <span>Total Orders:</span> {{ $totalOrders }}<br>
        <span>Avg. Order Value:</span> RM{{ number_format($avgOrderValue, 2) }}<br>
        <span>New Customers:</span> {{ $newCustomers }}<br>
    </div>
    <h3>Order Status Breakdown</h3>
    <table>
        <thead>
            <tr>
                <th>Status</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderStatusChartData['labels'] as $i => $label)
                <tr>
                    <td>{{ $label }}</td>
                    <td>{{ $orderStatusChartData['data'][$i] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p style="margin-top:40px; font-size:12px; color:#888;">Generated at {{ now()->format('Y-m-d H:i:s') }}</p>
</body>
</html> 