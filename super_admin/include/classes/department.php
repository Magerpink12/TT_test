<?php

// CREATE TABLE `ttwizard1`.`department` ( 
// `id` INT NOT NULL AUTO_INCREMENT , 
// `name` VARCHAR(255) NOT NULL , 
// `faculty` VARCHAR(255) NOT NULL , 
// `timetable_coordinator` VARCHAR(255) NOT NULL , 
// `max_level_range` INT NOT NULL , 
// PRIMARY KEY (`id`)) ENGINE = InnoDB;

// error #1452 #1452

class Department extends Objects_class{
    public static $db_table_fields = array('name','faculty','max_level_range');
    public static $db_table = 'department';

    public $id;
    public $name;
    public $faculty;
    public $coordinator;
    public $phone;
    public $max_level_range;

    public function validate_and_save()
    {
        $sql = "SELECT * FROM ".static::$db_table." WHERE name='".$this->name."'";
        // // echo $sql;
        // $the_object = $this->find_by_query($sql);
        // $this->max_level_range = $the_object[0];
        $data = $this->find_by_query($sql);
        if (empty($data)) {
            $this->save();
           return true;
        }
        print_r($data);
        return false;
    }

    public static function dept_relate($dept_name)
    {
        $sql = "SELECT name, phone FROM coordinator WHERE department='".$dept_name."' AND coordinate='Department'";
        $depts = static::find_by_query($sql);
       
       if (empty($depts)) {
        $obj = array('name'=>'<i>NULL</i>','phone'=>'<i>NULL</i>');
       
       }else{
        $obj = array('name'=>$depts[0]->name,'phone'=>$depts[0]->phone);
       }
       return $obj;
    }

    public static function notice()
    {
        // $sql = "SELECT * FROM department d WHERE NOT EXISTS (SELECT department FROM coordinator c WHERE d.name =! c.department AND coordinate='Department')";
        // $sql = "SELECT * FROM `department` WHERE name NOT IN (SELECT department FROM coordinator WHERE coordinate='department')";
        $sql = "SELECT * FROM `department` WHERE name NOT IN (SELECT department FROM coordinator WHERE department IS NOT NULL AND coordinate='department')";
        $depts = static::find_by_query($sql);
        return $depts;
    }


}

?>