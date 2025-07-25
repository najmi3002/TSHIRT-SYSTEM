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
        <span>Start Date:</span> <?php echo e($startDate->format('Y-m-d')); ?><br>
        <span>End Date:</span> <?php echo e($endDate->format('Y-m-d')); ?><br>
        <span>Total Revenue:</span> RM<?php echo e(number_format($totalRevenue, 2)); ?><br>
        <span>Total Orders:</span> <?php echo e($totalOrders); ?><br>
        <span>Avg. Order Value:</span> RM<?php echo e(number_format($avgOrderValue, 2)); ?><br>
        <span>New Customers:</span> <?php echo e($newCustomers); ?><br>
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
            <?php $__currentLoopData = $orderStatusChartData['labels']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($label); ?></td>
                    <td><?php echo e($orderStatusChartData['data'][$i]); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <p style="margin-top:40px; font-size:12px; color:#888;">Generated at <?php echo e(now()->format('Y-m-d H:i:s')); ?></p>
</body>
</html> <?php /**PATH C:\xampp\htdocs\tshirt-system\resources\views/admin/reports/pdf.blade.php ENDPATH**/ ?>