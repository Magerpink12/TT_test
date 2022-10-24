<?php

class Database{

    public $connection;

    public function connect(){
        $this->connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

        if($this->connection->error){
            echo 'Errorrrrr '. $this->connection->mysqli_error;
        }else{
            // echo "connect";
        }
    }

    function __construct(){

        $this->connect();
    }

    public function query($sql)
    {
        $result = $this->connection->query($sql);
        if (!$result) {
            die('Query Error '.$this->connection->error);
        }
        return $result;
    }

    public function escape_string($string)
    {
        $escaped_string = $this->connection->real_escape_string($string);
        return $escaped_string;
    }

    public function the_insert_id()
    {
        return $this->connection->insert_id;
    }


}

$database = new Database();



?>
