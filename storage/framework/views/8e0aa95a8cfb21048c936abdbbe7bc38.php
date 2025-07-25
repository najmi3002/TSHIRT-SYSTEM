<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?php echo e($invoice->invoice_number); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .invoice-title {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .invoice-number {
            font-size: 18px;
            color: #666;
        }
        .company-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .bill-to, .from {
            width: 45%;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }
        .customer-details, .company-details {
            line-height: 1.6;
        }
        .customer-details p, .company-details p {
            margin: 5px 0;
        }
        .customer-name, .company-name {
            font-weight: bold;
            font-size: 16px;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .invoice-table th {
            background-color: #f8f9fa;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #ddd;
            font-weight: bold;
        }
        .invoice-table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }
        .text-right {
            text-align: right;
        }
        .totals {
            float: right;
            width: 300px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .total-row.final {
            border-top: 2px solid #333;
            padding-top: 10px;
            font-weight: bold;
            font-size: 18px;
        }
        .notes, .terms {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .notes h4, .terms h4 {
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: bold;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-paid { background-color: #d4edda; color: #155724; }
        .status-partial { background-color: #fff3cd; color: #856404; }
        .status-pending { background-color: #f8d7da; color: #721c24; }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="invoice-title">INVOICE</div>
        <div class="invoice-number">#<?php echo e($invoice->invoice_number); ?></div>
    </div>

    <div class="company-info">
        <div class="bill-to">
            <div class="section-title">Bill To:</div>
            <div class="customer-details">
                <p class="customer-name"><?php echo e($invoice->customer_name); ?></p>
                <p><?php echo e($invoice->customer_email); ?></p>
                <p><?php echo e($invoice->customer_phone); ?></p>
                <p><?php echo e($invoice->customer_address); ?></p>
            </div>
        </div>
        <div class="from">
            <div class="section-title">From:</div>
            <div class="company-details">
                <p class="company-name">T-SHIRT SYSTEM SDN BHD</p>
                <p>No2 Tingkat 1, Jalan Pulai Indah Satu, Taman Pulai Indah,</p>
                <p>Kangar, Perlis, 01000</p>
                <p>Phone: +60 13-656 1726</p>
                <p>Email: milestones7979@gmail.com</p>
            </div>
        </div>
    </div>

    <div class="invoice-details">
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <div>
                <strong>Invoice Date:</strong> <?php echo e($invoice->invoice_date->format('M d, Y')); ?>

            </div>
            <div>
                <strong>Due Date:</strong> <?php echo e($invoice->due_date->format('M d, Y')); ?>

            </div>
            <div>
                <strong>Status:</strong> 
                <span class="status-badge status-<?php echo e($invoice->payment_status); ?>">
                    <?php echo e(ucfirst($invoice->payment_status)); ?>

                </span>
            </div>
        </div>
    </div>

    <table class="invoice-table">
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-right">Quantity</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo e($invoice->product_name); ?></td>
                <td class="text-right"><?php echo e($invoice->quantity); ?></td>
                <td class="text-right">RM<?php echo e(number_format($invoice->unit_price, 2)); ?></td>
                <td class="text-right">RM<?php echo e(number_format($invoice->subtotal, 2)); ?></td>
            </tr>
        </tbody>
    </table>

    <div class="clearfix">
        <div class="totals">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>RM<?php echo e(number_format($invoice->subtotal, 2)); ?></span>
            </div>
            <?php if($invoice->tax_amount > 0): ?>
                <div class="total-row">
                    <span>Tax:</span>
                    <span>RM<?php echo e(number_format($invoice->tax_amount, 2)); ?></span>
                </div>
            <?php endif; ?>
            <?php if($invoice->discount_amount > 0): ?>
                <div class="total-row">
                    <span>Discount:</span>
                    <span>-RM<?php echo e(number_format($invoice->discount_amount, 2)); ?></span>
                </div>
            <?php endif; ?>
            <div class="total-row final">
                <span>Total:</span>
                <span>RM<?php echo e(number_format($invoice->total_amount, 2)); ?></span>
            </div>
            <?php if($invoice->deposit_amount > 0): ?>
                <div class="total-row">
                    <span>Deposit Paid:</span>
                    <span>RM<?php echo e(number_format($invoice->deposit_amount, 2)); ?></span>
                </div>
                <div class="total-row final">
                    <span>Balance Due:</span>
                    <span>RM<?php echo e(number_format($invoice->balance_amount, 2)); ?></span>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if($invoice->notes): ?>
        <div class="notes">
            <h4>Notes:</h4>
            <p><?php echo e($invoice->notes); ?></p>
        </div>
    <?php endif; ?>

    <?php if($invoice->terms_conditions): ?>
        <div class="terms">
            <h4>Terms & Conditions:</h4>
            <p><?php echo e($invoice->terms_conditions); ?></p>
        </div>
    <?php endif; ?>

    <div style="margin-top: 50px; text-align: center; color: #666; font-size: 12px;">
        <p>Thank you for your business!</p>
        <p>For any questions, please contact us at info@tshirtsystem.com</p>
    </div>
</body>
</html> <?php /**PATH C:\xampp\htdocs\tshirt-system\tshirt-system\resources\views/admin/invoices/pdf.blade.php ENDPATH**/ ?>