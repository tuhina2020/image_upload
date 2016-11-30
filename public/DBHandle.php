<?php
class DBHandle {
	private $sql_obj, $redis_obj;

	function __construct() {
		require_once dirname(__FILE__) . '/sql_operation.php';
		require_once dirname(__FILE__) . '/redis_operation.php';
		$this->sql_obj = new SQLOperation();
		$this->redis_obj = new RedisOperation();
	}

	function createProduct($name, $price) {
		$id = $this->sql_obj->createProduct($name, $price);
		return $id;
	}

	function insert_image_to_redis($id, $image) {
		$this->redis_obj->insertImage($image, $id);
	}

	function insert_image_to_sql($id, $image) {
		$this->sql_obj->addImage($id, $image);
	}

	function getImageFromForm() {
		if(isset($_FILES['pic'])) {
			if($_FILES['pic']['error'] == 0) {
				$path = $_FILES['pic']['tmp_name'];
				$data = file_get_contents($path);
				$type = pathinfo($path, PATHINFO_EXTENSION);
				$base64 = base64_encode($data);
				return $base64;
			}
		}
		else {
			echo 'couldnot upload image';
			return 0;
		}
	}

	public function getUnSizedSQL() {
		$result = $this->sql_obj->getUnSized();
		return $result;
	}

	public function getSizedSQL() {
		$result = $this->sql_obj->getSized();
		return $result;
	}
	public function getImageRedis($key) {
        return $this->redis_obj->getImage($key);
    }

    public function deleteEntryRedis($key) {
        //strip predis prefix
        $prefix = $this->redis_obj->getOptions()->__get('prefix')->getPrefix();
        if (substr($key, 0, strlen($prefix)) == $prefix) {
            $key = substr($key, strlen($prefix));
        }
        //delete the key
        $this->redis_obj->del($key);
    }

    public function writeResizeSQL($id, $image, $size) {
    	$this->sql_obj->addResizedSQL($id, $image, $size);
    }
}
?>