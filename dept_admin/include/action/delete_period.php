
<?php
include('../configuration/init.php');
if (isset($_POST['delete'])) {

    $day = $_POST['day'];
    $department = $_POST['department'];
    $level = $_POST['level'];
    $semester = $_POST['semester'];
    $course = $_POST['course'];


    $period = new Period();
    $periods = $period->find_by_query("SELECT * from period WHERE department='{$department}' AND level='{$level}' AND semester='{$semester}'"); 
    $periods = array_shift($periods);
    
    $week = json_decode($periods->periods);

    $old = ($week->$day);
    $new = new stdClass();
    foreach ($old as $cos => $value) {
        if ($cos != $course) {
            $new->$cos = $value;
        }
    }
    $week->$day = $new;
    $periods->periods = json_encode($week);
    
    if ($periods->save()) {
        echo true;
    }else{
        echo false;
    }


    // echo json_encode($week);
}

?>