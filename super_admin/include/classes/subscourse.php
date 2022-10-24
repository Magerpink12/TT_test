<?php

class Subscourse extends Objects_class
{
    public static $db_table_fields = array('id', 'department', 'level', 'gst_courses', 'other_courses');
    public static $db_table = "subs_course";
    public $id;
    public $department;
    public $level;
    public $gst_courses;
    public $other_courses;


    public static function find_subs_by_dept_and_level($department, $level = '', $semester, $category, $faculty = null)
    {
        if ($level != '') {

            $subcourse = static::find_by_query("SELECT * FROM subs_course WHERE department='{$department}' AND level={$level} LIMIT 1");
            $subcourse = array_shift($subcourse);
            if ($subcourse) {


                if ($category == 'gst') {

                    $gst_courses = $subcourse->gst_courses;

                    $gst_courses = json_decode($gst_courses);
                    return $gst_courses->$semester;
                } else {

                    $other_courses = $subcourse->other_courses;

                    $other_courses = json_decode($other_courses);

                    return $other_courses->$semester;
                }
            }else{
                return array();
            }
        } else {

            if ($faculty != null) {

                $subcourses = static::find_by_query("SELECT * FROM subs_course WHERE department IN (SELECT name FROM department WHERE faculty='{$faculty}')");
            } else {

                $subcourses = static::find_by_query("SELECT * FROM subs_course WHERE department='{$department}'");
            }

            if ($subcourses) {
                
                if ($category == 'gst') {
                    $gst_courses_array = array();
                    foreach ($subcourses as $subcourse) {
    
                        $gst_courses = $subcourse->gst_courses;
    
                        $gst_courses = json_decode($gst_courses);
                        array_push($gst_courses_array, $gst_courses->$semester);
                    }
    
                    return $gst_courses_array;
                } else {
                    $other_courses_array = array();
                    foreach ($subcourses as $subcourse) {
    
                        $other_courses = $subcourse->other_courses;
    
                        $other_courses = json_decode($other_courses);
                        array_push($other_courses_array, $other_courses->$semester);
                    }
                    return $other_courses_array;
                }
            }else{
                return array();
            }
        }
    }
}

// $other_courses = Subscourse::find_subs_by_dept_and_level('Physics','100','First','gst');

// $Subscourse;
