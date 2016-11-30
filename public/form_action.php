<?php
	require_once dirname(__FILE__) . '/DBHandle.php';
	if(isset($_POST['name']) && isset($_POST['price'])) {
		$name = $_REQUEST['name'];
		$price = $_REQUEST['price'];
		$db = new DBHandle();
		$id = $db->createProduct($name, $price);
		$image = $db->getImageFromForm();
		if($id) {
			if($image) {
				$db->insert_image_to_sql($id, $image);
				$db->insert_image_to_redis($id, $image);			
			} else {
				echo 'Error uploading image';
			}
		}
		else {
			echo 'failed to create product in sql';
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>OnCreate</title>
</head>
<body>
created product with params name: <?php echo $_REQUEST["name"].', price'.$_REQUEST["price"]; ?>

<form id="productForm" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method= "post" enctype="multipart/form-data">
	
	<div class="mainArea">

		<label>Name:</label>
		<input type="text" id="name" name="name" required>

		<label>Price:</label>
		<input type="text" id="price" name="price" required>

		<input type="file" name="pic" id = "pic" accept="image/*">

		<button id="btnSave">Save</button>

	</div>

</form>

</body>
</html>