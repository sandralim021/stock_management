<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/print/report.css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <title>Print Report</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="invoice-title">
                    <h2>Stock Management System</h2>
                </div>
                <hr>
                <div class="row">
                    <div class="col-xs-6">
                        <address>
                        <strong>Start Date:</strong><br>
                            <?php echo $form_data['start_date']; ?><br>
                        </address>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <address>
                            <strong>End Date:</strong><br>
                            <?php echo $form_data['end_date']; ?><br>
                        </address>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>Report summary</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <td><strong>Order Date</strong></td>
                                        <td class="text-center"><strong>Customer Name</strong></td>
                                        <td class="text-center"><strong>Customer Contact</strong></td>
                                        <td class="text-right"><strong>Net Total</strong></td>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $totalAmount = 0; ?>
                                <?php foreach($report_data as $row): ?>
                                <tr>
                                    <td><?php echo $row->order_date; ?></td>
                                    <td class="text-center"><?php echo $row->customer_name; ?></td>
                                    <td class="text-center"><?php echo $row->customer_contact; ?></td>
                                    <td class="text-right"><?php  echo '₱ '.number_format($row->net_total,2); ?></td>
                                    <?php $totalAmount += $row->net_total; ?>
                                </tr>
                                <?php endforeach; ?>
                                <tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Total Amount</strong></td>
    								<td class="thick-line text-right"><?php echo '₱ '.number_format($totalAmount,2); ?></td>
    							</tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>