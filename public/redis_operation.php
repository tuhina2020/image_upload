<?php
class RedisOperation
{
    //Database connection link
    private $con;
 
    //Class constructor
    function __construct()
    {
        require_once dirname(__FILE__) . '/predis/src/Autoloader.php';
        Predis\Autoloader::register();
        $this->con = new Predis\Client(['host' => '127.0.0.1', 'port' => 6379]);
    }
 
    public function insertImage($id, $image){

    	$result = $this->con->set('image_'+$id, $image);
        //If statment executed successfully
        if ($result) {
            echo 'create'.$result;
        } else {
            echo 'failed to created product';
            return 0;
		}			
    }

    public function getImage($key) {
        return $this->con->get($key);
    }

    public function deleteEntry($key) {
        //strip predis prefix
        $prefix = $this->con->getOptions()->__get('prefix')->getPrefix();
        if (substr($key, 0, strlen($prefix)) == $prefix) {
            $key = substr($key, strlen($prefix));
        }
        //delete the key
        $this->con->del($key);
    }

}