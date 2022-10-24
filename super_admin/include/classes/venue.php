<?php

// CREATE TABLE `ttwizard1`.`venue` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(255) NOT NULL , `capacity` INT NOT NULL , `department` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;


class Venue extends Objects_class{
    public static $db_table_fields = array('id','name','capacity','department');
    public static $db_table = 'venue';

    public $id;
    public $name;
    public $capacity;
    public $department;
    // public $v_priority = array();


}




?>