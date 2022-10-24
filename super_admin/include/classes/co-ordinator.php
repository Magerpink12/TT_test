<?php

/*

CREATE TABLE `ttwizard1`.`coordinator` ( 
    `id` INT NOT NULL AUTO_INCREMENT , 
    `name` VARCHAR(255) NOT NULL , 
    `faculty` VARCHAR(255) NOT NULL , 
    `department` VARCHAR(255) NOT NULL , 
    `title` VARCHAR(255) NOT NULL , 
    `username` VARCHAR(255) NOT NULL , 
    `phone` VARCHAR(255) NOT NULL , 
    `email` VARCHAR(255) NOT NULL , 
    `image_path` VARCHAR(255) NOT NULL , 
    `password` VARCHAR(255) NOT NULL , 
    PRIMARY KEY (`id`)) ENGINE = InnoDB;

*/


class Coordinator extends Objects_class{
    public static $db_table_fields = array('name','department','title','faculty','coordinate','password','username','phone','email','image_path');
    public static $db_table = 'coordinator';
    public $id;
    public $name;
    public $department;
    public $title;
    public $faculty;
    public $password;
    public $username;
    public $phone;
    public $email;
    public $coordinate;
    public $image_path ='';
    public $error ='';

    public function validate_and_save()
    {
        // $sql = "SELECT * FROM ".static::$db_table." WHERE department='".$this->department."'";

        if (isset($this->id)) {
            $sql = "SELECT * FROM ".static::$db_table." WHERE department='".$this->department."' AND coordinate='".$this->coordinate."' AND id !=".$this->id;
            $this->error = 'The Department Already has Coordinator!';
            if ($this->coordinate=='Faculty') {
                $sql = "SELECT * FROM ".static::$db_table." WHERE faculty='".$this->faculty."' AND coordinate='".$this->coordinate."' AND id !=".$this->id;
                $this->error = 'The Faculty Already has Coordinator!';
                
            }
        }else{
            $sql = "SELECT * FROM ".static::$db_table." WHERE department='".$this->department."' AND coordinate='".$this->coordinate."'";
            $this->error = 'The Department Already has Coordinator!';
            if ($this->coordinate=='Faculty') {
                $sql = "SELECT * FROM ".static::$db_table." WHERE faculty='".$this->faculty."' AND coordinate='".$this->coordinate."'";
                $this->error = 'The Faculty Already has Coordinator!';
                
            }
        }
        $data = $this->find_by_query($sql);
        if (empty($data)) {
            $this->error = '';
            $this->save();
           return true;
        }else{
        print_r($data);
        return false;
        }
    }

    public static function coo_dept_fac($dept_name)
    {
        $sql = "SELECT faculty FROM department WHERE name='".$dept_name."'";
        $depts = static::find_by_query($sql);
       
       if (empty($depts)) {
        $fac = '---------';
       
       }else{
        $fac = $depts[0]->faculty;
       }
       return $fac;
       
    }

   


    

}


?>