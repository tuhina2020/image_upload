<?php
 
class SQLOperation
{
    //Database connection link
    private $con, $db;
 
    //Class constructor
    function __construct()
    {
        //Getting the DbConnect.php file
        require_once dirname(__FILE__) . '/database_conn.php';
 
        //Creating a DbConnect object to connect to the database
        $this->db = new DbConnect();
 
        //Initializing our connection link of this class
        //by calling the method connect of DbConnect class
        $this->con = $this->db->connect();
    }
 
    //Method will create a new product
    public function createProduct($name,$price){

        $stmt = $this->con->prepare("INSERT INTO image_new(name, price) values(?, ?)");

        //Binding the parameters
        $stmt->bind_param("ss", $name, $price);

        //Executing the statment
        $result = $stmt->execute();

        //Closing the statment
        $stmt->close();

        //If statment executed successfully
        if ($result) {
            return $this->con->insert_id;
        } else {
            echo 'failed to created product';
            return 0;
		}			
    }

    public function addImage($id, $image){
        $stmt = $this->con->prepare("UPDATE image_new SET IMAGE=? WHERE ID=?");
        //Binding the parameters
        $stmt->bind_param("ss", $image, $id);

        //Executing the statment
        $result = $stmt->execute();

        //Closing the statment
        $stmt->close();

        //If statment executed successfully
        if ($result) {
            echo 'inserted image';
            return 1;
        } else {
            echo 'failed to insert image';
            return 0;
        }
    }

    public function getUnSized() {
        printf('unsized');
        $query = "SELECT id FROM image_new WHERE image_256 IS NULL OR image_512 IS NULL";
        $result = $this->db->queryResult($query);
        return $result;
    }

    public function getSized() {
        printf('sized');
        $query = "SELECT * FROM image_new WHERE image_256 IS NOT NULL AND image_512 IS NOT NULL";
        $result = $this->db->queryResult($query);
        return $result;
    }

    public function addResizedSQL($id, $image, $size) {
        $stmt = $this->con->prepare("UPDATE image_new SET IMAGE_".$size."=? WHERE ID=?");
        //Binding the parameters
        $stmt->bind_param("ss", $image, $id);

        //Executing the statment
        $result = $stmt->execute();

        //Closing the statment
        $stmt->close();

        //If statment executed successfully
        if ($result) {
            echo 'inserted image'.$size;
            return 1;
        } else {
            echo 'failed to insert image';
            return 0;
        }
    }
}
?>