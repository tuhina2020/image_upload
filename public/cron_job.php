<?php
Class CronJob {
	private $db;

	function __construct() {
		require_once dirname(__FILE__) . '/DBHandle.php';
		$this->db = new DBHandle();
	}

	private convertWrite($size, $width, $height) {
		$newHeight = ($size / $width) * $height;
		$im->resizeImage($width,$newHeight, imagick::FILTER_LANCZOS, 0.9, true);
		$this->db->writeResizeSQL($id, base64_encode($image), $size);
	}

	public function cronJob() {
		$unsized = $this->db->getUnSizedSQL();
		if($unsized) {
			while($row = $unsized->fetch_assoc()) {
				//for each id
				$id = $row['id'];
				//get image for redis
				$image = $this->db->getImageRedis($id);
				if($image) {
					//decode image
					$im = new imagick(base64_decode($image));
					// get dimensions
					$imageprops = $im->getImageGeometry();
					$width = $imageprops['width'];
					$height = $imageprops['height'];

					$task1 = new ProcessCallbackTask(function () {
					    convertWrite(256, $width, $height);
					});

					//set $task1 to convert to 512
					$task2 = new ProcessCallbackTask(function () {
					    convertWrite(512, $width, $height);
					});

					$manager = new ProcessManager();

					//asynchronously write to sql
					$manager->addTask($task1);
					$manager->addTask($task2);

					while ($manager->tick()) {
					    usleep(250);
					}

					//delete from redis
					$this->db->deleteEntryRedis($id);
				}
				else {
					echo "image not found in redis";
				}
			}
		}
		else {
			echo 'no images left to resize';
		}
	}
}
?>