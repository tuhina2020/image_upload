<?php

//Class DbConnect
class DbConnect
{
    //Variable to store database link
    private $con;
 
    //Class constructor
    function __construct()
    {
        //Including the constants.php file to get the database constants
        $user = 'root';
        $password = 'root';
        $db = 'images_sql';
        $host = 'localhost';
 
        //connecting to mysql database
        $this->con = new mysqli($host, $user, $password, $db);
    }
 
    //This method will connect to the database
    public function connect()
    {
        //Checking if any error occured while connecting
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        else{
        	echo 'successful connection   ';
        }
 
        //finally returning the connection link 
        return $this->con;
    }

    public function queryResult($query) {
        $result = mysqli_query($this->con, $query);
        return $result;
    }
 
}
?>