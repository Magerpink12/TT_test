<style>
    .notification {
        position: fixed;
        width: 250px;
        right: 2%;
        top: 70px;
        z-index: 99;
        transform: translateX(120%);
    }

    .slide-in {
        animation: slide-in 1s forwards ease;
    }

    .slide-out {
        animation: slide-out 1s forwards ease;
        pointer-events: none;
        /* display: none; */
    }

    @keyframes slide-in {

        0% {
            transform: translateX(100%);
        }

        40% {
            transform: translateX(-20%);
        }

        70% {
            transform: translateX(20%);
        }

        100% {
            transform: translateX(0%);
        }

    }

    @keyframes slide-out {
        0% {
            transform: translateX(0%);
        }

        40% {
            transform: translateX(20px);
        }

        70% {
            transform: translateX(-20%);
        }

        100% {
            transform: translateX(120%);
        }
    }


    .notification .card {
        box-shadow: -5px 5px 9px rgba(0, 50, 100, .3);
    }

    .notification .card #cancel {
        font-size: larger;
        font-weight: bolder;
        cursor: pointer;
    }

    .notification .card #cancel:hover {
        color: white !important;
    }

    .period-hover:hover {
        background-color: #212529;
        color: lime;
    }

    .delete :hover {
        color: red;
    }

    .error {
        height: 70px;
        background-color: rgba(200, 0, 0, .8);
        border-radius: 5px;
        transition: .2s;
        color: white;

    }

    .error:hover {
        background-color: rgba(150, 0, 0, .8);
    }
</style>

<div class="notification">
    <div class="card">
        <div class="card-header not bg-info">
            <div id="cancel" class="text-danger text-right">&times;</div>

            <p><svg style="color: white;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#ffffff" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell align-middle">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg><span class="text-light" id="not-title"> Welcome</span></p>
        </div>
        <div class="card-body">
            <p id="not-body">Greetings!!!</p>
        </div>
    </div>
</div>

<?php


if (isset($_GET['level']) && isset($_GET['semester'])) {

    $level = $_GET['level'];
    $semester = $_GET['semester'];

    if ($level == '100' or $level == '200' or $level == '300' or $level == '400' or $level == '500') {
    } else {
        header('Location: ?page=manage_timetable');
    }
    if ($semester == "second") {
        $semester = "Second";
    }
    if ($semester == "first") {
        $semester = "First";
    }
    if ($semester == "Second" || $semester == "First") {
    } else {
        header('Location: ?page=manage_timetable');
    }
} else {
    header('Location: ?page=manage_timetable');
}


$sql = "SELECT * FROM course WHERE department IN (SELECT name FROM department WHERE faculty='{$user->faculty}') AND department='{$user->department}' AND level='{$level}' AND semester='{$semester}' ORDER BY id DESC"; // level MANUAL
$sql1 = "SELECT * FROM course WHERE department IN (SELECT name FROM department WHERE faculty='{$user->faculty}') AND department='{$user->department}' AND level='{$level}' ORDER BY id DESC";
$sql2 = "SELECT * FROM venue WHERE department IN (SELECT name FROM department WHERE faculty='{$user->faculty}') AND department='{$user->department}' ORDER BY id DESC";

$courses = Course::find_by_query($sql);

if (empty($courses)) {

    $courses = Course::find_by_query($sql1);
}
$venues = Venue::find_all();
// $venues = Venue::find_by_query($sql2);

$period = new Period();

$periods = $period->find_by_query("SELECT * from period WHERE department='{$user->department}' AND level='{$level}' AND semester='{$semester}'"); //level MANUAL
$dept_periods = $period->find_by_query("SELECT * from period WHERE department='{$user->department}' AND semester='{$semester}'"); //level MANUAL


$std_dept_periods = array();
foreach ($dept_periods as $dept_level) {


    $dept_level->periods = (array)json_decode($dept_level->periods);
    array_push($std_dept_periods, $dept_level);
}
// echo "<pre>";
// print_r($std_dept_periods);
// echo "</pre>";


if (empty($periods)) {

    $period_init = array(
        "MONDAY" => new stdClass(),
        "TUESDAY" => new stdClass(),
        "WEDNESDAY" => new stdClass(),
        "THURSDAY" => new stdClass(),
        "FRIDAY" => new stdClass(),
        "SATURDAY" => new stdClass()
    );

    $period_init = json_encode($period_init);

    $period->department = $user->department;
    $period->level = $level; //level MANUAL
    $period->periods = $period_init;
    $period->semester = $semester;
    $period->save();
    header("Location: ?page=timetable&level={$level}&semester={$semester}");
}

$periods = array_shift($periods);
$week = json_decode($periods->periods);
$my_total_periods = 0;

foreach ($week as $day => $value) {

    foreach ($week->$day as $co => $value2) {
        $my_total_periods++;
        //         $start = explode(':',$week->$day->$co->start);
        //         $end = explode(':',$week->$day->$co->end);

        //         echo "['{$day}', '{$co}', new Date(0, 0, 0, {$start[0]}, {$start[1]}, 0), new Date(0, 0, 0, {$end[0]}, {$end[1]}, 0)],<br>";
    }
}

// echo "<hr><pre>";
// print_r($week);
// echo "</pre>";


// other courses

$gst = Subscourse::find_subs_by_dept_and_level($user->department, $level, $semester, 'gst');
$other_courses = Subscourse::find_subs_by_dept_and_level($user->department, $level, $semester, 'other_courses');

// echo "<hr><pre>";
// print_r($gst);
// echo "</pre><hr>";

$gst_periods = Period::find_my_gst_periods($level, $semester, $gst);
$all_gst_periods = Period::find_my_gst_periods($level, $semester, $gst,true);

// echo "<hr><pre>";
// print_r($gst_periods);   
// echo "</pre><hr>";

$gst_total_periods = 0;
foreach ($gst_periods as $day => $value) {

    foreach ($gst_periods->$day as $co => $value2) {
        $gst_total_periods++;
        $start = explode(':', $gst_periods->$day->$co->start);
        $end = explode(':', $gst_periods->$day->$co->end);

        // echo "['{$day}', '{$co} ({$gst_periods->$day->$co->venue})', new Date(0, 0, 0, {$start[0]}, {$start[1]}, 0), new Date(0, 0, 0, {$end[0]}, {$end[1]}, 0)],<br>";
    }
}


// echo "<hr><pre>";
// print_r($other_courses);
// echo "</pre><hr>";

$other_courses_periods = Period::find_my_subs_periods($level, $semester, $other_courses);
$all_other_courses_periods = Period::find_all_subs_periods($semester);

// echo "<hr><pre>";
// print_r($other_courses_periods);
// echo "</pre><hr>";

$others_total_periods = 0;
foreach ($other_courses_periods as $other_courses_period) {
    foreach ($other_courses_period as $day => $value) {

        foreach ($other_courses_period->$day as $co => $value2) {
            $others_total_periods++;
            $start = explode(':', $other_courses_period->$day->$co->start);
            $end = explode(':', $other_courses_period->$day->$co->end);

            // echo "['{$day}', '{$co} ({$other_courses_period->$day->$co->venue})', new Date(0, 0, 0, {$start[0]}, {$start[1]}, 0), new Date(0, 0, 0, {$end[0]}, {$end[1]}, 0)],<br>";
        }
    }
}

?>


<script>
    var title = sessionStorage.getItem('title')
    var body = sessionStorage.getItem('body')
    var color = sessionStorage.getItem('color')
    sessionStorage.removeItem('title')
    sessionStorage.removeItem('body')
    sessionStorage.removeItem('color')

    $('#not-title').text(title ? title : "Welcome")
    $('#not-body').text(body ? body : "Greetings!!!")
    $('.not').removeClass('bg-info').addClass(color ? color : 'bg-info')

    // $('#not-body').text('Greetings')
    $('.notification').removeClass('slide-out').addClass('slide-in')
    setTimeout(() => {
        $('.notification').removeClass('slide-in').addClass('slide-out')
    }, 10000)

    $('#cancel').click(() => {
        $('.notification').removeClass('slide-in').addClass('slide-out')
    })


    $('.sidebar').toggleClass('collapsed')

    function togglefullscreen() {
        var doc = window.document;
        var docEl = doc.documentElement;

        var requestFullScreen = docEl.requestFullscreen || docEl.mozRequestFullScreen || docEl
            .webkitRequestFullScreen || docEl.msRequestFullscreen;
        var cancelFullScreen = doc.exitFullscreen || doc.mozCancelFullScreen || doc.webkitExitFullScreen || doc
            .msExitFullscreen
        // $('.sidebar').toggleClass('collapsed')
        if (!doc.fullscreenElement && !doc.mozFullScreenElement && !doc.webkitFullscreenElement && !doc
            .msFullscreenElement) {
            requestFullScreen.call(docEl)
        } else {
            cancelFullScreen.call(doc)

        }
    }
</script>


<main class="content">
    <div class="container-fluid p-0">
    <div class="row">

<div class="col-12 col-md-12 col-lg-4 card">
    <div class="card-header bg-info">
        <h6 class="h6 mb-3"><span class="card-title text-light">Add Periods For <?php echo $user->department . " (Level {$level} {$semester} Semester)" ?>
            </span><span class="h6 small"></span></h6>
    </div>
    <div style="min-height: 400px;" class="card-body">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
            <label class="form-check-label" for="flexSwitchCheckChecked"><span class="badge bg-info">Check For Auto Generation</span></label>
        </div>

        <script>
            $('#flexSwitchCheckChecked').change(function() {
                if ($('#flexSwitchCheckChecked').prop('checked') == false) {
                    $('#auto').prop('disabled', true)
                    $('#manual').prop('disabled', false)
                } else {
                    $('#auto').prop('disabled', false)
                    $('#manual').prop('disabled', true)
                }
            })
        </script>

        <div class="input-group mb-3">
            <select name="course" type="text" class="form-select" placeholder="">
                <option value="">..Choose Course</option>
                <?php foreach ($courses as $course) : ?>

                    <option data-unit="<?php echo $course->unit ?>" value="<?php echo $course->course_code ?>"><?php echo $course->course_code . " - ". $course->title ?></option>

                <?php endforeach ?>

            </select>
            <span class="input-group-text" id="basic-addon2">Students No. (332)</span>
        </div>

        <fieldset id="manual">

            <div class="input-group mb-3">
                <select name="day" type="text" class="form-select">
                    <option value="">..Select Day</option>
                    <option value="MONDAY">MONDAY</option>
                    <option value="TUESDAY">TUESDAY</option>
                    <option value="WEDNESDAY">WEDNESDAY</option>
                    <option value="THURSDAY">THURSDAY</option>
                    <option value="FRIDAY">FRIDAY</option>
                    <option value="SATURDAY">SATURDAY</option>

                </select>
                <span class="input-group-text" id="basic-addon2">Day</span>
            </div>
            <div class="input-group mb-3">
                <select name="venue" type="text" class="form-select">
                    <option value="">..Select Venue</option>
                    <?php foreach ($venues as $venue) : ?>

                        <option value="<?php echo $venue->name ?>"><?php echo $venue->name . " ($venue->capacity)" ?></option>

                    <?php endforeach ?>

                </select>
                <span class="input-group-text" id="basic-addon2">Venue</span>
            </div>

            <!-- <div class="input-group mb-3">
                <span for="duration" class="input-group-text">Duration (hrs)/Day</span>
                <select name="duration" id="duration" class="form-select">
                    <option value="">1</option>
                    <option selected value="">2</option>
                    <option value="">3</option>
                </select>
            </div> -->

            <div class="col-8"></div>
            <div class="input-group mb-3">
                <select name="start" class="form-select">
                    <option value="">Start</option>
                    <option value="8:00">8:00AM</option>
                    <option value="9:00">9:00AM</option>
                    <option value="10:00">10:00AM</option>
                    <option value="11:00">11:00AM</option>
                    <option value="12:00">12:00PM</option>
                    <option value="14:00">2:00PM</option>
                    <option value="15:00">3:00PM</option>
                    <option value="16:00">4:00PM</option>
                </select>
                <!-- <input name="start" type="time" min="" class="form-control" placeholder="Start Time" aria-label="start"> -->
                <span class="input-group-text">To</span>
                <select name="end" class="form-select">
                    <option value="">End</option>
                    <option value="8:00">8:00AM</option>
                    <option value="9:00">9:00AM</option>
                    <option value="10:00">10:00AM</option>
                    <option value="11:00">11:00AM</option>
                    <option value="12:00">12:00PM</option>
                    <option value="13:00">1:00PM</option>
                    <option value="15:00">3:00PM</option>
                    <option value="16:00">4:00PM</option>
                </select>
                <!-- <input name="end" type="time" class="form-control" placeholder="End Time" aria-label="end"> -->
            </div>

        </fieldset>

        <!-- <fieldset id="auto" disabled>

            <div class="input-group mb-3">
                <span for="duration" class="input-group-text">Duration (hrs)/Week for Auto Gen</span>
                <select name="duration" id="duration" class="form-select">
                    <option value="">1</option>
                    <option selected value="">2</option>
                    <option value="">3</option>
                </select>
            </div>
        </fieldset> -->

    </div>
    <div class="card-footer text-right bg-info">
        <input style="background-color: #222e3c;" type="submit" id="add_period" value="Add Period" class="btn btn-primary">
    </div>

</div>

<div class="col-12 col-md-12 col-lg-8">
    <div class="card">
        <div class="card-header bg-info">
            <h6 class="h6 mb-3"><span class="card-title text-light">TIMETABLE For <?php echo $user->department . " (Level {$level} {$semester} Semester)" ?></span><br>
                <button style="background-color: #222e3c !important;" class="btn bg-primary"><a class="text-light" href="javascript:()" onclick="togglefullscreen()"><i class="align-middle" data-feather="external-link"></i>Full Screen</a></button>
        </div>
        <div class="card-body">
            <div id="example5.1" class="" style="min-height:400px;"></div>
        </div>
        <div class="card-footer bg-info">
            <form action="print/print_timetable.php" method="post">
                <input readonly type="hidden" value="<?php echo $user->faculty ?>" name="faculty" id="">
                <input readonly type="hidden" value="<?php echo $user->department ?>" name="department" id="">
                <input readonly type="hidden" value="<?php echo $level ?>" name="level" id="">
                <input readonly type="hidden" value="<?php echo $semester ?>" name="semester" id="">
                <button style="background-color: #222e3c !important;" class="btn text-light" type="submit" name="print"><i class="align-middle" data-feather="download"></i>Print Timetable</button>
            </form>
        </div>

    </div>
</div>
</div>
        <div class="row">

            <div class="col-12 col-lg-8">
                <div class="col-12">
                    <div style="color: #bbbbbb;" class="card">
                        <div class="card-header bg-dark"><span class="mute">PERIODS</span></div>
                        <div style="background-color: #222e3c; " class="card-body">
                            <div class="col-12">
                                <div style="border: .1px solid grey;" class="card">
                                    <div style="background-color: #222e3c;" class="card-header">
                                        <div class="card-title text-light">MY PERIODs</div>
                                        <div class="card-subtitle mute"><?php echo $user->department . " (Level {$level} {$semester} Semester)" ?></div>
                                        <div class="text-right">Total Period(s) <?php echo $my_total_periods ?></div>
                                    </div>
                                    <div class="table-responsive">
                                        <table style="color: #888888;border: .1px solid gray; background-color: #222e3c; font-size: 12px;" class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th style="color: #eeeeee;" scope="col">Course</th>
                                                    <th scope="col">Day</th>
                                                    <th scope="col">Start</th>
                                                    <th scope="col">End</th>
                                                    <th scope="col">Venue</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0;
                                                foreach ($week as $day => $value) :

                                                    foreach ($week->$day as $co => $value) :
                                                        $i++;
                                                ?>
                                                        <tr class="period-hover">
                                                            <th scope="row"><?php echo $i ?></th>
                                                            <td style="color: #eeeeee;"><?php echo $co ?></td>
                                                            <td><?php echo $day ?></td>
                                                            <td><?php echo $week->$day->$co->start ?></td>
                                                            <td><?php echo $week->$day->$co->end ?></td>
                                                            <td><?php echo $week->$day->$co->venue ?></td>
                                                            <td><a class="delete delete_my_period" href="javascript:" day="<?php echo $day ?>" course="<?php echo $co ?>"><i class="align-middle" data-feather="trash-2"></a></i></td>
                                                        </tr>

                                                <?php endforeach;
                                                endforeach; ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <script>
                                        $(document).ready(() => {
                                            $('.delete_my_period').click(function() {

                                                var day = $(this).attr('day')
                                                var course = $(this).attr('course')

                                                var data = {
                                                    delete: true,
                                                    department: "<?php echo $user->department ?>",
                                                    level: "<?php echo $level ?>",
                                                    day,
                                                    course,
                                                    semester: "<?php echo $semester ?>"
                                                }

                                                console.log(data)

                                                $.ajax({
                                                    method: 'POST',
                                                    data: data,
                                                    url: "include/action/delete_period.php",
                                                    success: (response) => {
                                                        response = parseInt(response)
                                                        if (response == 1) {

                                                            sessionStorage.setItem('title', 'Done!')
                                                            sessionStorage.setItem('body', 'Period Deleted Successfully')
                                                            sessionStorage.setItem('color', 'bg-success')


                                                            window.location.reload()

                                                        } else {

                                                            $('#not-title').text(" False!")
                                                            $('#not-body').text("Period Deleting Error!")
                                                            $('.not').removeClass('bg-info').addClass('bg-danger')

                                                            $('.notification').removeClass('slide-out').addClass('slide-in')
                                                            setTimeout(() => {
                                                                $('.notification').removeClass('slide-in').addClass('slide-out')
                                                            }, 5000)



                                                        }
                                                    }
                                                })



                                            })
                                        })
                                    </script>

                                    <div style="background-color: #222e3c;" class="card-footer">

                                    </div>
                                </div>




                                <div style="border: .1px solid grey;" class="card">
                                    <div style="background-color: #222e3c;" class="card-header">
                                        <div class="card-title text-light">SUBSIDIARY PERIODs</div>
                                        <div class="card-subtitle mute"><?php echo $user->department . " (Level {$level} {$semester} Semester)" ?></div>
                                        <div class="text-right">Total Period(s) <?php echo $others_total_periods ?></div>
                                        <div class="text-right">Total Sub(s) Taken <?php echo count($other_courses) ?></div>
                                    </div>
                                    <div class="table-responsive">
                                        <table style="color: #888888;border: .1px solid gray; background-color: #222e3c; font-size: 12px;" class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th style="color: #eeeeee;" scope="col">Course</th>
                                                    <th scope="col">Day</th>
                                                    <th scope="col">Start</th>
                                                    <th scope="col">End</th>
                                                    <th scope="col">Venue</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0;
                                                foreach ($other_courses_periods as $other_courses_period) :
                                                    foreach ($other_courses_period as $day => $value) :
                                                        foreach ($other_courses_period->$day as $co => $value2) :
                                                            $i++;
                                                ?>
                                                            <tr class="period-hover">
                                                                <th scope="row"><?php echo $i ?></th>
                                                                <td style="color: #eeeeee;"><?php echo $co ?></td>
                                                                <td><?php echo $day ?></td>
                                                                <td><?php echo $other_courses_period->$day->$co->start ?></td>
                                                                <td><?php echo $other_courses_period->$day->$co->end ?></td>
                                                                <td><?php echo $other_courses_period->$day->$co->venue ?></td>
                                                                <td>
                                                                    <p class="delete"><i class="align-middle" data-feather="trash-2"></p></i>
                                                                </td>
                                                            </tr>

                                                <?php
                                                        endforeach;
                                                    endforeach;
                                                endforeach;
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>

                                    <div style="background-color: #222e3c;" class="card-footer">

                                    </div>
                                </div>

                            </div>

                        </div>
                        <div style="background-color: #222e3c;" class="card-footer"></div>
                    </div>
                </div>
            </div>


            <div style="color: #bbbbbb;" class="col-12 col-lg-4 card">
                <div class="card-header bg-dark"><span class="mute">NOTIFICATIONS</span></div>
                <div style="background-color: #222e3c; " class="card-body">
                    <div class="col-12">
                        <div style="border: .1px solid grey;" class="card">
                            <div style="background-color: #222e3c;" class="card-header">
                                <div class="card-title text-light">Warnings!!</div>
                                <div class="text-right">Total Warning(s) <?php echo 0 ?></div>
                            </div>

                            <div style="background-color: #222e3c;" class="warnings">
                                <?php

                                foreach ($week as $myday => $myvalue) {
                                    foreach ($week->$myday as $myco => $myvalue2) {

                                        $mystart = explode(':', $week->$myday->$myco->start);
                                        $myend = explode(':', $week->$myday->$myco->end);


                                        foreach ($gst_periods as $gstday => $gstvalue) {
                                            foreach ($gst_periods->$gstday as $gstco => $gstvalue2) {

                                                $gststart = explode(':', $gst_periods->$gstday->$gstco->start);
                                                $gstend = explode(':', $gst_periods->$gstday->$gstco->end);


                                                if ($myday == $gstday) {

                                                    if (intval($gstend[0]) <= intval($myend[0]) && intval($gstend[0]) > intval($mystart[0])) {
                                                        $error = "<div class='m-1 error'>";
                                                        $error .= "<div class='text-warning p-1'>$gstco<br><span class='text-light'> $myco Clashed with $gstco on $myday at Time: $mystart[0] </span></div>";
                                                        // $error .= $myday. ' - '. $mystart[0].' - ' . $myco . " - " . $gstco . "<br>";
                                                        $error .= "</div>";

                                                        echo $error;
                                                    }

                                                    // if ($mystart[0] == $gststart[0] ) {

                                                    // echo $myday. ' - '. $mystart[0].' - ' . $myco . " - " . $gstco . "<br>";
                                                    //}
                                                }
                                            }
                                        }

                                        foreach ($other_courses_periods as $other_courses_period) {
                                            foreach ($other_courses_period as $subsday => $subsvalue) {
                                                // print_r($myday) ;
                                                foreach ($other_courses_period->$subsday as $subsco => $subsvalue2) {

                                                    $ttt = $other_courses_period->$subsday->$co ?? null;
                                                    if($ttt != null){

                                                        $subsstart = explode(':', $other_courses_period->$subsday->$co->start);
                                                        // print_r($subsstart) ;
                                                        $subsend = explode(':', $other_courses_period->$subsday->$co->end);
                                                        // print_r($subsend) ;
                                                        
                                                        
                                                        if ($myday == $subsday) {
                                                            
                                                            if ((intval($subsend[0]) <= intval($myend[0]) && intval($subsend[0]) > intval($mystart[0])) || ($mystart[0] == $subsstart[0])) {
                                                                $error = "<div class='m-1 error'>";
                                                                $error .= "<div class='text-warnin p-1'>$subsco<br><span class='text-light'> $myco Clashed with $subsco on $myday at Time: $mystart[0] </span></div>";
                                                                $error .= "</div>";
                                                                echo $error;
                                                            }
                                                        
                                                    }
                                                    




                                                        // if ($mystart[0] == $subsstart[0]) {

                                                        //     echo $myday. ' - '. $mystart[0].' - ' . $myco . " - " . $subsco . "<br>";
                                                        // }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                ?>

                                <!-- <div style='height: 50px; background-color: rgba(250, 0, 0, 1); border-radius: 5px;' class='m-1'>
                                
                                </div> -->

                            </div>


                            <div style="background-color: #222e3c;" class="card-footer">

                            </div>
                        </div>
                    </div>

                </div>
                <div style="background-color: #222e3c;" class="card-footer"></div>
            </div>


        </div>
        
    </div>
</main>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!-- <script type="text/javascript" src="js/gstatic/loader.js"></script> -->

<script type="text/javascript">
    function timetable_display() {
        google.charts.load("current", {
            packages: ["timeline"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var container = document.getElementById('example5.1');
            var chart = new google.visualization.Timeline(container);
            var dataTable = new google.visualization.DataTable();
            dataTable.addColumn({
                type: 'string',
                id: 'Day'
            });
            dataTable.addColumn({
                type: 'string',
                id: 'Course'
            });
            dataTable.addColumn({
                type: 'date',
                id: 'Start'
            });
            dataTable.addColumn({
                type: 'date',
                id: 'End'
            });
            dataTable.addRows([
                <?php foreach ($week as $day => $value) :
                    foreach ($week->$day as $co => $value2) :

                        $start = explode(':', $week->$day->$co->start);
                        $end = explode(':', $week->$day->$co->end);
                ?>

                        ['<?php echo $day ?>', '<?php echo $co . " ({$week->$day->$co->venue})" ?>', new Date(0, 0, 0, <?php echo $start[0] ?>, <?php echo $start[1] ?>, 0), new Date(0, 0, 0, <?php echo $end[0] ?>, <?php echo $end[1] ?>, 0)],

                    <?php endforeach ?>
                <?php endforeach ?>



                <?php
                foreach ($other_courses_periods as $other_courses_period) :
                    foreach ($other_courses_period as $day => $value) :
                        foreach ($other_courses_period->$day as $co => $value2) :

                            $start = explode(':', $other_courses_period->$day->$co->start);
                            $end = explode(':', $other_courses_period->$day->$co->end);
                ?>

                            ['<?php echo $day ?>', '<?php echo $co . " ({$other_courses_period->$day->$co->venue})" ?>', new Date(0, 0, 0, <?php echo $start[0] ?>, <?php echo $start[1] ?>, 0), new Date(0, 0, 0, <?php echo $end[0] ?>, <?php echo $end[1] ?>, 0)],

                        <?php endforeach ?>
                    <?php endforeach ?>
                <?php endforeach ?>



                <?php foreach ($gst_periods as $day => $value) :
                    foreach ($gst_periods->$day as $co => $value2) :

                        $start = explode(':', $gst_periods->$day->$co->start);
                        $end = explode(':', $gst_periods->$day->$co->end);
                ?>

                        ['<?php echo $day ?>', '<?php echo $co . " ({$gst_periods->$day->$co->venue})" ?>', new Date(0, 0, 0, <?php echo $start[0] ?>, <?php echo $start[1] ?>, 0), new Date(0, 0, 0, <?php echo $end[0] ?>, <?php echo $end[1] ?>, 0)],

                    <?php endforeach ?>
                <?php endforeach ?>

                // ['MONDAY', 'CSC6629', new Date(0, 0, 0, 11, 0, 0), new Date(0, 0, 0, 13, 0, 0)],
                // ['TUESDAY', 'CSC6758', new Date(0, 0, 0, 14, 0, 0), new Date(0, 0, 0, 15, 30, 0)],
                // ['WEDNESDAY', 'MTH6567', new Date(0, 0, 0, 10, 0, 0), new Date(0, 0, 0, 12, 0, 0)],
                // ['THURSDAY', 'CSC3348', new Date(0, 0, 0, 12, 30, 0), new Date(0, 0, 0, 14, 0, 0)],
                // ['FRIDAY', 'PHY6546', new Date(0, 0, 0, 14, 30, 0), new Date(0, 0, 0, 16, 0, 0)],
                // ['SATURDAY', 'CHM6556', new Date(0, 0, 0, 12, 0, 0), new Date(0, 0, 0, 14, 0, 0)],
            ]);

            var options = {
                timeline: {
                    showRowLabels: true
                },
                tooltip: {
                    isHtml: true
                },

            };

            chart.draw(dataTable, options);
        }
    }
    timetable_display()
</script>

<script>
    // $('g').click(function() {
    //     alert()
    // })

    $("#add_period").click(function() {
        var course = $("[name='course']").val();
        var unit = $("[name='course']").find(':selected').data('unit');
        var day = $("[name='day']").val();
        var venue = $("[name='venue']").val();
        var start = $("[name='start']").val();
        var end = $("[name='end']").val();


        if (course == '' || unit == '' || day == '' || venue == '' || start == '' || end == '') {

            $('#not-title').text("Error!")
            $('#not-body').text("Some Necessary Fields are Omited!")
            $('.not').removeClass('bg-info').addClass('bg-danger')

            $('.notification').removeClass('slide-out').addClass('slide-in')
            setTimeout(() => {
                $('.notification').removeClass('slide-in').addClass('slide-out')
            }, 10000)
            return false
        }

        var start_hours = parseInt(start.split(':')[0])
        var end_hours = parseInt(end.split(':')[0])

        if (end_hours <= start_hours) {
            $('#not-title').text("Invalid Entry!")
            $('#not-body').text("The Start Time must be Greater than End Time")
            $('.not').removeClass('bg-info').addClass('bg-danger')

            $('.notification').removeClass('slide-out').addClass('slide-in')
            setTimeout(() => {
                $('.notification').removeClass('slide-in').addClass('slide-out')
            }, 10000)
            return false
        }

        var hours = end_hours - start_hours

        if (hours > unit) {
            $('#not-title').text("Invalid Entry!")
            $('#not-body').text("The Course Selected is maximum of " + unit + " Hours Lecture in a Week!")
            $('.not').removeClass('bg-info').addClass('bg-danger')

            $('.notification').removeClass('slide-out').addClass('slide-in')
            setTimeout(() => {
                $('.notification').removeClass('slide-in').addClass('slide-out')
            }, 10000)
            return false
        }

        var existing_courses_obj = '<?php echo json_encode($week) ?>'
        existing_courses_obj = JSON.parse(existing_courses_obj)

        var existing_gst_courses_obj = '<?php echo json_encode($gst_periods) ?>'
        existing_gst_courses_obj = JSON.parse(existing_gst_courses_obj)

        var all_existing_gst_courses_obj = '<?php echo json_encode($all_gst_periods) ?>'
        all_existing_gst_courses_obj = JSON.parse(all_existing_gst_courses_obj)

        var all_existing_other_courses_objs = '<?php echo json_encode($all_other_courses_periods) ?>'
        all_existing_other_courses_objs = JSON.parse(all_existing_other_courses_objs)

        var existing_other_courses_objs = '<?php echo json_encode($other_courses_periods) ?>'
        existing_other_courses_objs = JSON.parse(existing_other_courses_objs)
        
        var std_dept_periods = '<?php echo json_encode($std_dept_periods) ?>'
        std_dept_periods = JSON.parse(std_dept_periods)
        
        
        // console.log(all_existing_other_courses_objs)
        var maga = true;
                // console.log(all_existing_other_courses_objs)
                all_existing_other_courses_objs.forEach(all_existing_other_courses_obj => {
        
                    for (const day1 in all_existing_other_courses_obj) {
        
                        if (Object.hasOwnProperty.call(all_existing_other_courses_obj, day1)) {
                            const element = all_existing_other_courses_obj[day1];
                            if (day1 == day) {
        
                                for (const course1 in element) {
                                    period = element[course1]

                                    const venueee = period.venue
                                    const start = parseInt(period.start.split(':')[0])
                                    const end = parseInt(period.end.split(':')[0])
                                    
                                    if (start_hours >= start && start_hours < end) {
                                        
                                        // console.log(period);
                                        if (venueee == venue) {
                                            
                                            // console.log('Venue clash at: '+start)
                                            $('#not-title').text(" Oops! Venue.")
                                            $('#not-body').text("The Venue " + venue + " Clash with "+course1+" at : " + start_hours)
                                            $('.not').removeClass('bg-info').addClass('bg-danger')
                                            
                                            $('.notification').removeClass('slide-out').addClass('slide-in')
                                            setTimeout(() => {
                                                $('.notification').removeClass('slide-in').addClass('slide-out')
                                            }, 10000)
                                            maga = false
                                            return false
                                        }
                                        
                                        
                                        
                                    } else if (end_hours > start && end_hours <= end) {
                                        // console.log(period);
                                        
                                        if (venueee == venue) {
                                            
                                            // console.log('Venue clash at: '+end)
                                            $('#not-title').text(" Oops! Clash in Subsidiary Periods.")
                                            $('#not-body').text("The Venue " + venue + " Clash with "+course1+" at : " + start_hours)
                                            $('.not').removeClass('bg-info').addClass('bg-danger')
            
                                            $('.notification').removeClass('slide-out').addClass('slide-in')
                                            setTimeout(() => {
                                                $('.notification').removeClass('slide-in').addClass('slide-out')
                                            }, 10000)
                                            maga = false
            
                                            return false
                                        }
        
        
        
                                    }
        
                                }
        
                            }
                        }
                    }
        
                });



        var total_time = 0
        for (const day1 in existing_courses_obj) {

            if (Object.hasOwnProperty.call(existing_courses_obj, day1)) {
                const element = existing_courses_obj[day1];

                        period = element[course]
                        if (period) {
                            console.log(period)
                            
                            const start = parseInt(period.start.split(':')[0])
                            const end = parseInt(period.end.split(':')[0])
                            
                            total_time += (end- start)
                            
                        }

            }
            
        }

        console.log(total_time + (end_hours - start_hours))
        if (total_time + (end_hours - start_hours) > unit) {
    
                $('#not-title').text(" Oops! Lecture Hours Exceeded.")
                $('#not-body').text("The Course Period Per Week is " + unit + "hrs, and " + (total_time) + "hrs Already Allocated.")
                $('.not').removeClass('bg-info').addClass('bg-warning')

                $('.notification').removeClass('slide-out').addClass('slide-in')
                setTimeout(() => {
                    $('.notification').removeClass('slide-in').addClass('slide-out')
                }, 10000)
                return false

            } 
        // return false;






        for (const day1 in existing_courses_obj) {

            if (Object.hasOwnProperty.call(existing_courses_obj, day1)) {
                const element = existing_courses_obj[day1];

                if (day1 == day) {

                    for (const course1 in element) {
                        period = element[course1]
                        const start = parseInt(period.start.split(':')[0])
                        const end = parseInt(period.end.split(':')[0])

                        if (start_hours >= start && start_hours < end) {

                            // console.log(' start clash at: '+start)

                            $('#not-title').text(" Oops! Clash in the Existing Periods.")
                            $('#not-body').text("The Course Period Start Point Entered Clash with " + course1 + " at : " + start_hours)
                            $('.not').removeClass('bg-info').addClass('bg-danger')

                            $('.notification').removeClass('slide-out').addClass('slide-in')
                            setTimeout(() => {
                                $('.notification').removeClass('slide-in').addClass('slide-out')
                            }, 10000)
                            return false

                        } else if (end_hours > start && end_hours <= end) {
                            // console.log('end clash at: '+end)

                            $('#not-title').text(" Oops! Clash in the Existing Periods.")
                            $('#not-body').text("The Course Period End Point Entered Clash with " + course1 + " at : " + end_hours)
                            $('.not').removeClass('bg-info').addClass('bg-danger')

                            $('.notification').removeClass('slide-out').addClass('slide-in')
                            setTimeout(() => {
                                $('.notification').removeClass('slide-in').addClass('slide-out')
                            }, 10000)
                            return false

                        }

                    }

                }
            }
        }
        // return false;



        // console.log(existing_gst_courses_obj)
        for (const day1 in existing_gst_courses_obj) {

            if (Object.hasOwnProperty.call(existing_gst_courses_obj, day1)) {
                const element = existing_gst_courses_obj[day1];
                if (day1 == day) {

                    for (const course1 in element) {
                        period = element[course1]
                        const start = parseInt(period.start.split(':')[0])
                        const end = parseInt(period.end.split(':')[0])

                        if (start_hours >= start && start_hours < end) {

                            // console.log(' start clash at: '+start)

                            $('#not-title').text(" Oops! Clash in GST Periods.")
                            $('#not-body').text("The Course Period Start Point Entered Clash with " + course1 + " at : " + start_hours)
                            $('.not').removeClass('bg-info').addClass('bg-danger')

                            $('.notification').removeClass('slide-out').addClass('slide-in')
                            setTimeout(() => {
                                $('.notification').removeClass('slide-in').addClass('slide-out')
                            }, 10000)
                            return false

                        } else if (end_hours > start && end_hours <= end) {
                            // console.log('end clash at: '+end)

                            $('#not-title').text(" Oops! Clash in GST Periods.")
                            $('#not-body').text("The Course Period End Point Entered Clash with " + course1 + " at : " + end_hours)
                            $('.not').removeClass('bg-info').addClass('bg-danger')

                            $('.notification').removeClass('slide-out').addClass('slide-in')
                            setTimeout(() => {
                                $('.notification').removeClass('slide-in').addClass('slide-out')
                            }, 10000)
                            return false

                        }

                    }

                }
            }
        }

var maga = true;
        console.log(existing_other_courses_objs)
        existing_other_courses_objs.forEach(existing_other_courses_obj => {

            for (const day1 in existing_other_courses_obj) {

                if (Object.hasOwnProperty.call(existing_other_courses_obj, day1)) {
                    const element = existing_other_courses_obj[day1];
                    if (day1 == day) {

                        for (const course1 in element) {
                            period = element[course1]
                            const start = parseInt(period.start.split(':')[0])
                            const end = parseInt(period.end.split(':')[0])

                            if (start_hours >= start && start_hours < end) {

                                // console.log(' start clash at: '+start)

                                $('#not-title').text(" Oops! Clash in Subsidiary Periods.")
                                $('#not-body').text("The Course Period Start Point Entered Clash with " + course1 + " at : " + start_hours)
                                $('.not').removeClass('bg-info').addClass('bg-danger')

                                $('.notification').removeClass('slide-out').addClass('slide-in')
                                setTimeout(() => {
                                    $('.notification').removeClass('slide-in').addClass('slide-out')
                                }, 10000)
                                maga = false
                                return false

                            } else if (end_hours > start && end_hours <= end) {
                                // console.log('end clash at: '+end)

                                $('#not-title').text(" Oops! Clash in Subsidiary Periods.")
                                $('#not-body').text("The Course Period End Point Entered Clash with " + course1 + " at : " + end_hours)
                                $('.not').removeClass('bg-info').addClass('bg-danger')

                                $('.notification').removeClass('slide-out').addClass('slide-in')
                                setTimeout(() => {
                                    $('.notification').removeClass('slide-in').addClass('slide-out')
                                }, 10000)
                                maga = false

                                return false

                            }

                        }

                    }
                }
            }

        });

        std_dept_periods.forEach(std_dept_period => {



            const level_sems = std_dept_period['periods'];

            // console.log(std_dept_period)

            for (const day2 in level_sems) {
                if (Object.hasOwnProperty.call(level_sems, day2)) {
                    const element = level_sems[day2];

                    // console.log(std_dept_period)
                    if (day2 == day) {

                        for (const coss in element) {

                            if (Object.hasOwnProperty.call(element, coss)) {
                                const element2 = element[coss];

                                const start = parseInt(element2.start.split(':')[0])
                                const end = parseInt(element2.end.split(':')[0])

                                if (start_hours >= start && start_hours < end) {
                                    if (venue == element2.venue) {
                                        console.log(element2)
                                        $('#not-title').text(" Oops! Venue Clash.")
                                        $('#not-body').text("The Venue Entered Clash with Level " + std_dept_period.level + "Course" + coss + " at Time " + start_hours + " on " + day2)
                                        $('.not').removeClass('bg-info').addClass('bg-danger')

                                        $('.notification').removeClass('slide-out').addClass('slide-in')
                                        setTimeout(() => {
                                            $('.notification').removeClass('slide-in').addClass('slide-out')
                                        }, 10000)
                                        return false
                                    }
                                } else if (end_hours > start && end_hours <= end) {
                                    if (venue == element2.venue) {
                                        $('#not-title').text(" Oops! Venue Clash.")
                                        $('#not-body').text("The Venue Entered Clash with Level " + std_dept_period.level + "Course" + coss + " at Time " + end_hours + " on " + day2)
                                        $('.not').removeClass('bg-info').addClass('bg-danger')

                                        $('.notification').removeClass('slide-out').addClass('slide-in')
                                        setTimeout(() => {
                                            $('.notification').removeClass('slide-in').addClass('slide-out')
                                        }, 10000)
                                        return false
                                    }
                                }
                            }
                        }


                    }
                }
            }


            if (std_dept_period['day'] == day) {

                for (const course1 in element) {
                    period = element[course1]
                    const start = parseInt(period.start.split(':')[0])
                    const end = parseInt(period.end.split(':')[0])

                    if (start_hours >= start && start_hours < end) {

                        // console.log(' start clash at: '+start)

                        $('#not-title').text(" Oops! Clash in Subsidiary Periods.")
                        $('#not-body').text("The Course Period Start Point Entered Clash with " + course1 + " at : " + start_hours)
                        $('.not').removeClass('bg-info').addClass('bg-danger')

                        $('.notification').removeClass('slide-out').addClass('slide-in')
                        setTimeout(() => {
                            $('.notification').removeClass('slide-in').addClass('slide-out')
                        }, 10000)
                        return false

                    } else if (end_hours > start && end_hours <= end) {
                        // console.log('end clash at: '+end)

                        $('#not-title').text(" Oops! Clash in Subsidiary Periods.")
                        $('#not-body').text("The Course Period End Point Entered Clash with " + course1 + " at : " + end_hours)
                        $('.not').removeClass('bg-info').addClass('bg-danger')

                        $('.notification').removeClass('slide-out').addClass('slide-in')
                        setTimeout(() => {
                            $('.notification').removeClass('slide-in').addClass('slide-out')
                        }, 10000)
                        return false

                    }

                }

            }
        });

        var data = {
            course,
            day,
            venue,
            start,
            end,
            add_period: true,
            level: "<?php echo $level ?>",
            semester: "<?php echo $semester ?>",
            department: "<?php echo $user->department ?>"
        }

        // console.log(unit)
        if (maga) {
            
            $.ajax({
                method: "POST",
                url: "include/action/period_ajax.php",
                data: data,
                success: function(res) {
                    // console.log(res)
                    sessionStorage.setItem('title', 'Done!')
                    sessionStorage.setItem('body', "Period Successfully Created.")
                    sessionStorage.setItem('color', 'bg-success')
                    location.reload()
                    
                }
            })
        }

    });
</script>