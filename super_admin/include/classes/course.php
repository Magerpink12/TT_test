<?php

class Course extends Objects_class{
    public static $db_table_fields = array('id','course_code','title','unit','semester','level','department',);
    public static $db_table ="course";
    public $course_code;
    public $id;
    public $title;
    public $department;
    public $unit;
    public $level;
    public $semester;


   







}


?>