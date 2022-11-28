<?php 	



require_once 'core.php';

$sql = "SELECT product.product_id, product.product_name, product.product_image, product.brand_id,
 		product.categories_id, product.quantity, product.rate, product.active, product.status,product.re_order_level, product.maximum_level, product.minimum_level,  brands.brand_name, categories.categories_name FROM product 
		INNER JOIN brands ON product.brand_id = brands.brand_id 
		INNER JOIN categories ON product.categories_id = categories.categories_id  
		WHERE product.status = 1";

$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $active = ""; 

 while($row = $result->fetch_array()) {
 	$productId = $row[0];
 	// active 
 	if($row[11] < $row[9]) {
 		// activate member
 		$active = "<label class='label label-success'>Full Stock </label>";
 	} else {
 		// deactivate member
 		$active = "<label class='label label-danger'>Re-order Level Reach</label>";
 	} // /else


	$brand = $row[13];
	$category = $row[12];

	$imageUrl = substr($row[2], 3);
	$productImage = "<img class='img-round' src='".$imageUrl."' style='height:30px; width:50px;'  />";

 	$output['data'][] = array( 		
 		// image
 		$productImage,
 		// product name
 		$row[1], 
 		// rate
 		$row[6],
 		// quantity 
 		$row[5], 
 		// brand
 		$brand,
 		// category 		
 		$category,
        //re-order-level
		$row[9],	
 		// active
 		$active,
 			
 		); 	
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);