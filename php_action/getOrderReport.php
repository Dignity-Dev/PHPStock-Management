<?php

require_once 'core.php';

if ($_POST) {

	$startDate = $_POST['startDate'];
	$date = DateTime::createFromFormat('m/d/Y', $startDate);
	$start_date = $date->format("Y-m-d");


	$endDate = $_POST['endDate'];
	$format = DateTime::createFromFormat('m/d/Y', $endDate);
	$end_date = $format->format("Y-m-d");

	$sql = "SELECT * FROM orders WHERE order_date >= '$start_date' AND order_date <= '$end_date' and order_status = 1";
	$query = $connect->query($sql);
	$cc = mysqli_num_rows($query);
	if ($cc > 0) {
?>
		<!DOCTYPE html>
		<html lang="en">

		<head>
			<meta charset="UTF-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title>General Report from <?php echo $start_date . ' to ' . $end_date; ?></title>
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
				<h1 style="text-align: center;">General Report from <?php echo $start_date . ' to ' . $end_date; ?></h1>
				<table border="1" cellspacing="0" cellpadding="0" style="width:100%;">
					<tr>
						<th>Order Date</th>
						<th>Client Name</th>
						<th>Contact</th>
						<th>Grand Total</th>
					</tr>


					<?php
					$totalAmount = "";
					while ($result = $query->fetch_assoc()) {
					?>
						<tr>
							<td>
								<center><?php echo $result['order_date']; ?></center>
							</td>
							<td>
								<center><?php echo $result['client_name']; ?></center>
							</td>
							<td>
								<center><?php echo $result['client_contact']; ?></center>
							</td>
							<td>
								<center><?php echo $result['grand_total']; ?></center>
							</td>
						</tr>
					<?php
						$totalAmount = $result['grand_total'];
					}
					?>


					<tr>
						<td colspan="3">
							<center>Total Amount</center>
						</td>
						<td>
							<center><?php echo $totalAmount; ?></center>
						</td>
					</tr>
				</table>
			</div>

			<br>
			<br>
			<br>
			<div class="print-c">
				<button onclick="window.print();">Print Now</button>
				<button onclick="window.history.back();">Back to report</button>
			</div>
		</body>

		</html>

<?php } else {

		echo "<script>window.alert('No record found to the selected date range'); window.location='../report.php';</script>";
	}
} ?>