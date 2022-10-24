<?php

// CREATE TABLE ttwizard1.faculty ( 
//     id INT NOT NULL AUTO_INCREMENT , 
//     name VARCHAR(255) NOT NULL , 
//     timetable_coordinator VARCHAR(255) NOT NULL , 
//     PRIMARY KEY (id)) ENGINE = InnoDB;

class Faculty extends Objects_class{

    public static $db_table_fields = array('id','name');
    public static $db_table = 'faculty';
    public $id;
    public $name;
    public $coordinator;
    public $phone;

    public static function fac_relate($fac_name)
    {
        $sql = "SELECT name, phone FROM coordinator WHERE faculty='".$fac_name."' AND coordinate='Faculty'";
       $facs = static::find_by_query($sql);
       
       if (empty($facs)) {
        $obj = array('name'=>'<i>NULL</i>','phone'=>'<i>NULL</i>');
       
       }else{
        $obj = array('name'=>$facs[0]->name,'phone'=>$facs[0]->phone);
       }
       return $obj;
    }

    public static function notice()
    {
        $sql = "SELECT * FROM `faculty` WHERE name NOT IN (SELECT faculty FROM coordinator WHERE coordinate='faculty')";
        $facs = static::find_by_query($sql);
        return $facs;
    }






}

?>