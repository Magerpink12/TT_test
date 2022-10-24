<?php


$pe_json = '
{
    "monday":{
        "CSC551":{
            "venue": "MPH",
            "start": "10:10am",
            "end": "03:40pm"
        },
        "PHY544":{
            "venue": "D3",
            "start": "22:22pm",
            "end": "23:21pm"
        }
    },
    "tuesday":{
        "CSC551":{
            "venue": "MPH",
            "start": "10:10am",
            "end": "03:40pm"
        },
        "PHY323":{
            "venue": "D3",
            "start": "22:22pm",
            "end": "23:21pm"
        }
    }
}';

$pe_ob = array(
    "monday" =>

    [
        "CSC551" =>
        [
            "venue" => "MPH",
            "start" => "10:10am",
            "end" => "03:40pm"
        ],

        "PHY544" =>
        [
            "venue" => "D3",
            "start" => "22:22pm",
            "end" => "23:21pm",
        ]

    ]

);


class Period extends Objects_class
{
    public static $db_table_fields = array('id', 'department', 'level', 'semester', 'periods', 'status');
    public static $db_table = 'period';
    public $id;
    public $department;
    public $level;
    public $semester;
    public $periods;
    public $status;


    public static function find_my_gst_periods($level, $semester, $courses_array,$all=false)
    {
        if ($level != '') {
            if ($all) {
             
                $sql = "SELECT * FROM " . static::$db_table;
            }else{

                $sql = "SELECT * FROM " . static::$db_table . " WHERE department='General Studies' AND level='{$level}' AND semester='{$semester}'";
            }

            $gst_periods = static::find_by_query($sql);
            $gst_periods = array_shift($gst_periods);

            if (!$gst_periods) {
                return array();
            }

            $week = json_decode($gst_periods->periods);

            $sample = new stdClass();

            foreach ($week as $day => $value) {

                foreach ($week->$day as $co => $value2) {

                    for ($i = 0; $i < count($courses_array); $i++) {
                        if ($courses_array[$i] == $co) {

                            if (!property_exists($sample, $day)) {

                                $sample->$day = new stdClass();
                            }
                            $sample->$day->$co = $value2;
                        }
                    }
                }
            }

            return $sample;
        } else {
            $sql = "SELECT * FROM " . static::$db_table . " WHERE department='General Studies' AND semester='{$semester}'";

            $gst_periods = static::find_by_query($sql);
            $gst_periods_array = array();
            foreach ($gst_periods as $gst_period) {

                $week = json_decode($gst_period->periods);

                $sample = new stdClass();

                foreach ($week as $day => $value) {

                    foreach ($week->$day as $co => $value2) {

                        for ($i = 0; $i < count($courses_array); $i++) {
                            $courses_array2 = $courses_array[$i];
                            for ($j = 0; $j < count($courses_array2); $j++) {

                                if ($courses_array2[$j] == $co) {

                                    if (!property_exists($sample, $day)) {

                                        $sample->$day = new stdClass();
                                    }
                                    $sample->$day->$co = $value2;
                                }
                            }
                        }
                    }
                }
                array_push($gst_periods_array, $sample);
            }


            return $gst_periods_array;
        }
    }


    public static function find_my_subs_periods($level, $semester, $courses_array,$all = false)
    {
        if ($level != '') {

            $periods_array = array();
            for ($i = 0; $i < count($courses_array); $i++) {

                $sample = new stdClass();
                $course = $courses_array[$i];
                if ($all) {
                    
                    $sql = "SELECT * FROM " . static::$db_table;
                }else{
                    
                    $sql = "SELECT * FROM " . static::$db_table . " WHERE department=(SELECT department FROM course WHERE course_code='{$course}') AND level='{$level}' AND semester='{$semester}'";
                }

                $periods = static::find_by_query($sql);
                if ($periods) {
                    # code...

                    $periods = array_shift($periods);

                    $week = json_decode($periods->periods);

                    foreach ($week as $day => $value) {

                        foreach ($week->$day as $co => $value2) {

                            if ($course == $co) {

                                if (!property_exists($sample, $day)) {

                                    $sample->$day = new stdClass();
                                }
                                $sample->$day->$co = $value2;
                            }
                        }
                    }
                    // $coooo = count((array)$sample);
                    if (!count((array)$sample) == 0) {

                        array_push($periods_array, $sample);
                    }
                }
            }
            return $periods_array;


        } else {

            $periods_array2 = array();
            for ($i = 0; $i < count($courses_array); $i++) {
                $periods_array = array();
                $courses_array2 = $courses_array[$i];
                for ($j = 0; $j < count($courses_array2); $j++) {

                    $sample = new stdClass();
                    $course = $courses_array2[$j];

                    $sql = "SELECT * FROM " . static::$db_table . " WHERE department=(SELECT department FROM course WHERE course_code='{$course}') AND semester='{$semester}'";

                    $periods = static::find_by_query($sql);
                    if ($periods) {
                        # code...

                        $periods = array_shift($periods);

                        $week = json_decode($periods->periods);

                        foreach ($week as $day => $value) {

                            foreach ($week->$day as $co => $value2) {

                                if ($course == $co) {

                                    if (!property_exists($sample, $day)) {

                                        $sample->$day = new stdClass();
                                    }
                                    $sample->$day->$co = $value2;
                                }
                            }
                        }
                        
                        if (!count((array)$sample) == 0) {

                            array_push($periods_array, $sample);
                        }
                    }
                }
                array_push($periods_array2, $periods_array);
            
            }
            return $periods_array2;
        }
        
    }



    public static function find_all_subs_periods($semester)
    {
                    $sql = "SELECT * FROM " . static::$db_table . " WHERE semester='{$semester}'";

                    $periods = static::find_by_query($sql);
                    $merge = array();
                    if ($periods) {
                        foreach ($periods as $period) {
                            $json = json_decode($period->periods);
                            array_push($merge, $json);
                            // echo "<pre>";
                            // print_r($merge);
                            // echo "</pre>";
                        }
                    return $merge;
                        

                    }
        
    }
}

// $courses_array = array('PHY1122', 'PHY1204');

// $periods = Period::find_my_subs_periods('100', 'Second', $courses_array);
