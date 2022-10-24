<?php

class Super extends Objects_class{
    public static $db_table_fields = array('name','password','username','email');
    public static $db_table = 'super_admin';
    public $id;
    public $name;
    public $password;
    public $username;
    public $email;
    public $coordinate = "Super";
    
}


?>