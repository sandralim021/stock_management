<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/print/invoice.css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Print Invoice</title>
</head>
<body>
    <!--Author      : @arboshiki-->
<div id="invoice">
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <main>
                <div class="row contacts">
                    <div class="col invoice-to">
                        <div class="text-gray-light">INVOICE TO:</div>
                        <h2 class="to"><?php echo $order->customer_name ?></h2>
                        <div class="address"><?php echo $order->customer_contact ?></div>
                    </div>
                    <div class="col invoice-details">
                        <h1 class="invoice-id">INVOICE NO: <?php echo $order->order_id ?></h1>
                        <div class="date">Date of Invoice: <?php echo $order->order_date ?></div>
                    </div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-left">PRODUCT NAME</th>
                            <th class="text-left">PRICE</th>
                            <th class="text-right">QTY</th>
                            <th class="text-right">TOTAL PRICE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; ?>
                        <?php foreach($details as $row): ?>
                        <tr>
                            <td class="no"><?php echo $i++; ?></td>
                            <td class="text-left"><?php echo $row->product_name; ?></td>
                            <td class="price"><?php echo '₱ '.number_format($row->price,2); ?></td>
                            <td class="qty"><?php echo $row->qty; ?></td>
                            <td class="total"><?php echo '₱ '.number_format($row->price * $row->qty,2); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">SUBTOTAL</td>
                            <td><?php echo "₱ ".number_format($order->sub_total, 2) ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">DISCOUNT <?php echo $order->discount.'%'?></td>
                            <td><?php echo ' - '.'₱ '.number_format($order->sub_total * $order->discount / 100,2) ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"></td>
                            <td colspan="2">NET TOTAL</td>
                            <td><?php echo '₱ '.number_format($order->net_total, 2) ?></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="thanks">Thank You!</div>
                <div><b>Important Notes:</b></div>
                <div class="notices">
                    <div class="notice">Paid: <?php echo '₱ '.number_format($order->paid, 2) ?></div>
                    <div class="notice">Due: <?php echo '₱ '.number_format($order->due, 2) ?></div>
                    <div class="notice">Payment Type: <?php echo $order->payment_type; ?></div>
                    <?php 
                        if($order->paid == $order->net_total){
                            $payment_status ='Full Payment';
                        }else if($order->paid < $order->net_total){
                            $payment_status ='Partial Payment';
                        }else if($order->paid == 0){
                            $payment_status ='No Payment';
                        }
                    ?>
                    <div class="notice">Payment Status: <?php echo $payment_status ?></div>
                </div>
            </main>
            <footer>
                Invoice was created on a computer and is valid without the signature and seal.
            </footer>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function (){
            window.print();
            return true;
    });
    $('#printInvoice').click(function(){
        Popup($('.invoice')[0].outerHTML);
        function Popup(data) 
        {
            window.print();
            return true;
        }
    });
</script>
</body>
</html>