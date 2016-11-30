<?php
require_once dirname(__FILE__) . '/DBHandle.php';
use AsyncPHP\Doorman\Manager\ProcessManager;
use AsyncPHP\Doorman\Task\ProcessCallbackTask;


// get list of ids without unsized images
$db = new DBHandle();
$unsized = $db->getUnSizedSQL();
if($unsized) {
	while($row = $unsized->fetch_assoc()) {
		//for each id
		$id = $row['id'];
		//get image for redis

		$image = $db->getImageRedis($id);

		if($image) {
			//decode image
			$im = new imagick(base64_decode($image));
			$imageprops = $im->getImageGeometry();
			$width = $imageprops['width'];
			$height = $imageprops['height'];
			//set $task1 to convert to 256
			$task1 = new ProcessCallbackTask(function () {
			    $newHeight = (256 / $width) * $height;
			    $im->resizeImage($wdth,$newHeight, imagick::FILTER_LANCZOS, 0.9, true);
			    $db->writeResizeSQL($id, base64_encode($image), 256);
			});

			//set $task1 to convert to 512
			$task2 = new ProcessCallbackTask(function () {
			    $newHeight = (512 / $width) * $height;
			    $im->resizeImage($width,$newHeight, imagick::FILTER_LANCZOS, 0.9, true);
			    $db->writeResizeSQL($id, base64_encode($image), 512);
			});

			$manager = new ProcessManager();

			//asynchronously write to sql
			$manager->addTask($task1);
			$manager->addTask($task2);

			while ($manager->tick()) {
			    usleep(250);
			}

			//delete from redis
			$db->deleteEntryRedis($id);
		}
		else {
			echo "image not found in redis";
		}
	}
}

?>