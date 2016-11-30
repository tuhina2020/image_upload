<?php
// Routes

$app->get('/', function(){
	echo phpinfo();
});

$app->get('/form', function($request, $response) {
	$response = $this->view->render($response, "index.phtml");
    return $response;
});

$app->get('/list/products', function($request, $response) {
	require_once '../public/DBHandle.php';

	$db = new DBHandle();
	$sized = $db->getSizedSQL();
	$newResponse = $response->withHeader('Content-type', 'application/json');
	$body = $response->getBody();
	$obj = {};

	if($sized) {
		while($row = $sized->fetch_assoc()) {
			//for each row
			$id = $row['id'];
			$name = $row['name'];
			$price = $row['price'];
			$image_512 = base64_decode($row['image_512']);
			$image_256 = base64_decode($row['image_256']);
			$obj['image_'.$id] = {'id': $id, 'name': $name, 'price': $price, 'image_512': $image_512, 'image_256': $image_256};
		}
	}
	$body->write($obj);
    return $newResponse;
});
