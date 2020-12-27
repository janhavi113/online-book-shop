<?php
session_start();
$product_ids = array();
//session_destroy();
if(filter_input(INPUT_POST,'process')){
	
	if(!empty($_SESSION['process_cart']))
	{
	
		$count = count($_SESSION['process_cart']);
		$product_ids = array_column($_SESSION['process_cart'],'id');
	if(!in_array(filter_input(INPUT_GET,'id'),$product_ids)){
	
	$_SESSION['process_cart'][$count] = array
	(
		//'id' => filter_input(INPUT_GET,'id'),
		'name' => filter_input(INPUT_POST,'name'),
		'mobile' => filter_input(INPUT_POST,'mobile'),
		'address' => filter_input(INPUT_POST,'address')
		//'city' => filter_input(INPUT_POST,'city'),
		//'city' => filter_input(INPUT_POST,'city'),
		//'pincode' => filter_input(INPUT_POST,'pincode')
		
		);
	}
	else{
		
		for($i = 0;$i < count($product_ids);$i++)
		{
			if($product_ids[$i]   ==filter_input(INPUT_GET,'id'))
			{
			//	$_SESSION['process_cart'][$i]['quantity'] +=filter_input(INPUT_POST,'quantity');
			}
		}
	}
	}

	else{
		$_SESSION['process_cart'][0] = array
		(
		'id' => filter_input(INPUT_GET,'id'),
		'name' => filter_input(INPUT_POST,'name'),
		'mobile' => filter_input(INPUT_POST,'mobile'),
		'address' => filter_input(INPUT_POST,'address')
		//'city' => filter_input(INPUT_POST,'city'),
		//'pincode' => filter_input(INPUT_POST,'pincode')
		);
	}
}
if(filter_input(INPUT_GET,'action')=='delete')
{
	foreach($_SESSION['process_cart']as $key => $product)
	{
		if($product['id']== filter_input(INPUT_GET,'id')){
			unset($_SESSION['process_cart'][$key]);
		}
	}
	$_SESSION['process_cart'] = array_values($_SESSION['process_cart']);
}
//pre_r($_SESSION);

function pre_r($array){
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}
?>

<!DOCTYPE html>
<html>
<head>
<title> Shopping cart </title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
<link rel="stylesheet" href="cart.css"/>
</head>
<body>
 <div class="container">
<?php
$servername = "localhost";
$username = "root";
$ppassword = "";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $ppassword, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query ="SELECT * FROM `detail`";
$result =mysqli_query($conn,$query);

if($result):
	if(mysqli_num_rows($result)>0):
		while($product = mysqli_fetch_assoc($result)):
		//print_r($product);

?> 

<?php
endwhile;
endif;
endif;

?>
<h1><center>Your Bill</h1>
<div style="clear:both"></div>
<br />


<div class="table-responsive">
<table class="table">
<tr><th colspan = "5"><h3>Order Details</h3></th></tr>
<?php
if(!empty($_SESSION['process_cart'])):

  foreach($_SESSION['process_cart'] as $key => $product):
?> 
<h5>Name :<?php echo $product['name'];?></h5><br>
<h5>Mobile :<?php echo $product['mobile'];?></h5><br>
<h5>Address :<?php echo $product['address'];?></h5><br>

<?php 
endforeach;
endif;
?>

<tr>
<th width="40%">Product Name </th>
<th width="10%">Quantity</th>
<th width="20%">Price</th>
<th width="15%">Total</th>

</tr>
<?php
if(!empty($_SESSION['shopping_cart'])):
$total = 0 ;
  foreach($_SESSION['shopping_cart'] as $key => $product):
?> 
<tr>
<td><?php echo $product['name'];?></td>
<td><?php echo $product['quantity'];?></td>
<td><?php echo $product['price'];?></td>
<td><?php echo number_format($product['quantity']*$product['price'],2);?></td>

<td>

</td>
</tr>


<?php 

$total = $total  +($product['quantity']*$product['price']);
endforeach;
?>
<tr>
<td colspan="3" align="right">total</td>
<td align="right"><?php echo number_format($total,2); ?></td>
<td></td>
</tr>
</tr>
<?php
endif;
$conn->close();?>
</table>
</div>
</div>

</body>
</html>