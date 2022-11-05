<?php

require_once 'core.php';

$orderId = $_GET['id'];

$sql = "SELECT order_date, client_name, client_contact, sub_total, vat, total_amount, discount, grand_total, paid, due FROM orders WHERE order_id = $orderId";

$orderResult = $connect->query($sql);
$orderData = $orderResult->fetch_array();

$orderDate = $orderData[0];
$clientName = $orderData[1];
$clientContact = $orderData[2];
$subTotal = $orderData[3];
$vat = $orderData[4];
$totalAmount = $orderData[5];
$discount = $orderData[6];
$grandTotal = $orderData[7];
$paid = $orderData[8];
$due = $orderData[9];


$orderItemSql = "SELECT order_item.product_id, order_item.rate, order_item.quantity, order_item.total,
product.product_name FROM order_item
	INNER JOIN product ON order_item.product_id = product.product_id 
 WHERE order_item.order_id = $orderId";
$orderItemResult = $connect->query($orderItemSql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Order Reciept</title>
	<style>
		.print-area {
			margin: 20px;
		}

		@media print {
			.print-c {
				display: none;
			}
		}
	</style>
</head>

<body>

	<div class="print-c">
		<button onclick="window.print();">Print Now</button>
		<button onclick="window.history.back();">Back to report</button>
	</div>
	<div class="print-area">
		<table border="1" cellspacing="0" cellpadding="20" width="100%">
			<thead>
				<tr>
					<th colspan="5">

						<center>
							Order Date : <?php echo $orderDate; ?>
							<center>Customer Name : <?php echo $clientName; ?></center>
							Contact : <?php echo $clientContact; ?>
						</center>
					</th>

				</tr>
			</thead>
		</table>
		<table border="0" width="100%;" cellpadding="5" style="border:1px solid black;border-top-style:1px solid black;border-bottom-style:1px solid black;">

			<tbody>
				<tr>
					<th>S.no</th>
					<th>Product</th>
					<th>Rate</th>
					<th>Quantity</th>
					<th>Total</th>
				</tr>
				<?php
				$x = 1;
				while ($row = $orderItemResult->fetch_array()) {
				?>
					<tr>
						<th><?php echo $x; ?></th>
						<th><?php echo $row[4]; ?></th>
						<th><?php echo $row[1]; ?></th>
						<th><?php echo $row[2]; ?></th>
						<th><?php echo $row[3]; ?></th>
					</tr>
				<?php
					$x++;
				} // /while

				?>
				<tr>
					<th></th>
				</tr>

				<tr>
					<th></th>
				</tr>

				<tr>
					<th>Sub Amount</th>
					<th><?php echo $subTotal; ?></th>
				</tr>

				<tr>
					<th>VAT (13%)</th>
					<th><?php echo $vat; ?></th>
				</tr>

				<tr>
					<th>Total Amount</th>
					<th><?php echo $totalAmount; ?></th>
				</tr>

				<tr>
					<th>Discount</th>
					<th><?php echo $discount; ?></th>
				</tr>

				<tr>
					<th>Grand Total</th>
					<th><?php echo $grandTotal; ?></th>
				</tr>

				<tr>
					<th>Paid Amount</th>
					<th><?php echo $paid; ?></th>
				</tr>

				<tr>
					<th>Due Amount</th>
					<th><?php echo $due; ?></th>
				</tr>
			</tbody>
		</table>
	</div>

</body>

</html>
<?php

$connect->close();

?>