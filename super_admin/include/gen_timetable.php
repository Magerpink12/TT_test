<?php

function dept_levels($department)
{
    $sql = "SELECT max_level_range FROM department WHERE name='{$department}'";
    $level = Department::find_by_query($sql);
    $level = intval($level[0]->max_level_range);
    return $level;
}

function depts($fac)
{
    $depts = Department::find_by_query("SELECT * FROM department WHERE faculty='{$fac}'");
    return $depts;
}

$faculties = Faculty::find_all();


?>


<main class="content">
    <div class="container-fluid p-0">

        <div class="row">
            <div class="col-12 col-lg-6">
                <div style="background-color: #222e3c; color: #e9ecef;" class="card">
                    <div class="card-header bg-dark">
                        <h5 style="color: #e9ecef !important;" class="card-title mb-0">All Faculties</h5>
                    </div>
                    <div class="card-body">

                        <?php foreach ($faculties as $faculty) : ?>
                            <ul class="list-group list-group-flush">

                                <ul class="list-goup-item">
                                    <li style="background-color: rgba(0,0,0,.1); color: #e9ecef; padding: 6px;" class="list-group-item">Faculty of <a class="fac" href="?page=timetable&faculty=<?php echo $faculty->name; ?>#department"><?php echo $faculty->name; ?></a></li>
                                </ul>

                            </ul>
                        <?php endforeach ?>


                    </div>
                </div>


            </div>
            <div id="department" class="col-12 col-lg-6">
                <?php
                if (isset($_GET['faculty'])) {

                    $faculty = $_GET['faculty'];

                    foreach ($faculties as $faculty1 => $value) {

                        if (array_search($faculty, (array)$value)) {

                            $depts = depts($value->name);
                            $dept_content = "<ul class='list-group list-group-flush'>";

                            foreach ($depts as $dept) {

                                $dept_content .= "<li style='background-color: #222e3c; color: #e9ecef;' class='list-group-item'>$dept->name Department 
                                                        <ul class='list-goup-item'>
                                                            <li style='background-color: rgba(0,0,0,.2); color: #e9ecef; padding: 6px;' class='list-group-item'>View <a href='?page=timetable&displaytt=true&faculty=$dept->faculty&department=$dept->name&level=all&semester=First'>First Semester's</a> Timetable</li>
                                                            <li style='background-color: rgba(0,0,0,.2); color: #e9ecef; padding: 6px' class='list-group-item'>View <a href='?page=timetable&displaytt=true&faculty=$dept->faculty&department=$dept->name&level=all&semester=Second'>Second Semester's</a> Timetable</li>
                                                        </ul>
                                                    </li>";
                            }

                            $dept_content .= "</ul>";

                            $content = "<div style='background-color: #222e3c; color: #e9ecef;' class='card'>
                                            <div class='card-header bg-dark'>
                                                <h5 style='color: #e9ecef !important;' class='card-title mb-0'><span id='head'>Faculty of $faculty</span></h5>
                                            </div>
                                            <div class='card-body head-body'>
                                                <ul class='list-goup-item'>
                                                    <li style='background-color: rgba(255,0,50,.2); color: #e9ecef; padding: 6px;' class='list-group-item'>Click <a href='?page=timetable&displaytt=true&faculty=$dept->faculty&level=all&semester=First'>here </a>to View the Faculty First Semester's Timetable</li>
                                                    <li style='background-color: rgba(255,0,50,.2); color: #e9ecef; padding: 6px;' class='list-group-item'>Click <a href='?page=timetable&displaytt=true&faculty=$dept->faculty&level=all&semester=Second'>here </a>to View the Faculty Second Semester's Timetable</li>
                                                </ul>
                                            $dept_content
                                            </div>
                                        </div>";

                            echo $content;
                        }
                    }
                }
                ?>


            </div>
        </div>
        <?php
        $body = "<div id='timetable' class='row'>
                        <div id='department' class='col-12 col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                <p class='mute'>  TIMETABLE </p>
                                <p class='mute'>&UpArrow; Select Faculty Or Department</p>
                                </div>
                                <div class='card-body'>
                                </div>
                                
                            </div>
                        </div>
                    </div>";

        if (isset($_GET['displaytt']) && $_GET['displaytt'] == 'true' && isset($_GET['semester'])) {

            $department = isset($_GET['department']) ? $_GET['department'] : 'All';
            $semester = $_GET['semester'];
            $faculty = $_GET['faculty'];

            if ($semester == "second") {
                $semester = "Second";
            }
            if ($semester == "first") {
                $semester = "First";
            }
            if ($semester == "Second" || $semester == "First") {
            } else {
                header("Location: ?page=timetable&faculty=$faculty#department");
            }

            $period = new Period();

            if (isset($_GET['department'])) {

                $periods = $period->find_by_query("SELECT * FROM period WHERE department='{$department}' AND semester='{$semester}'");

                $gst = Subscourse::find_subs_by_dept_and_level($department, '', $semester, 'gst');
                $other_courses = Subscourse::find_subs_by_dept_and_level($department, '', $semester, 'other_courses');

                $gst_periodss = Period::find_my_gst_periods('', $semester, $gst);

                $other_courses_periodss = Period::find_my_subs_periods('', $semester, $other_courses);
            } else {
                $periods = $period->find_by_query("SELECT * FROM period WHERE department IN (SELECT name FROM department WHERE faculty='{$faculty}') AND semester='{$semester}'");

                $gst = Subscourse::find_subs_by_dept_and_level($department, '', $semester, 'gst', $faculty);
                $other_courses = Subscourse::find_subs_by_dept_and_level($department, '', $semester, 'other_courses', $faculty);


                $gst_periodss = Period::find_my_gst_periods('', $semester, $gst);

                $other_courses_periodss = Period::find_my_subs_periods('', $semester, $other_courses);
            }

            // echo "<pre>";
            // print_r($periods);
            // echo "</pre>";





            $body = "<div id='timetable' class='row'>
                        <div id='department' class='col-12 col-lg-12'>
                            <div class='card'>
                                <div class='card-header'>
                                <p class='mute'>  TIMETABLE </p>
                                <p class='mute badge bg-dark'>&DownArrow; Faculty of $faculty <span style='font-size:20px'>/</span> $department Department <span style='font-size:20px'>/</span> $semester Semester</p>
                                </div>
                                <div class='card-body'>
                                    <div id='timetable_display' style='min-height:400px;'></div>
                                </div>
                                <div class='card-footer bg-info'>
                                <form action='print/print_timetable.php' method='post'>
                                <input readonly type='hidden' value='$faculty' name='faculty'>
                                <input readonly type='hidden' value='$department' name='department'>
                                <input readonly type='hidden' value='All' name='level'>
                                <input readonly type='hidden' value='$semester' name='semester'>
                                <button style='background-color: #222e3c !important;' class='btn text-light' type='submit' name='print'><i class='align-middle' data-feather='download'></i>Print Timetable</button>
                            </form>
                                </div>
                            </div>
                        </div>
                    </div>";
        }

        echo $body;

        ?>

    </div>
</main>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    function timetable_display() {
        google.charts.load("current", {
            packages: ["timeline"]
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var container = document.getElementById('timetable_display');
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


                <?php
                $my_couses_array = array();
                foreach ($periods as $period) :
                    $week = json_decode($period->periods);
                    foreach ($week as $day => $value) :
                        foreach ($week->$day as $co => $value2) :
                            array_push($my_couses_array, $co);

                            $start = explode(':', $week->$day->$co->start);
                            $end = explode(':', $week->$day->$co->end);
                ?>

                            ['<?php echo $day ?>', '<?php echo $co . " ({$week->$day->$co->venue})" ?>', new Date(0, 0, 0, <?php echo $start[0] ?>, <?php echo $start[1] ?>, 0), new Date(0, 0, 0, <?php echo $end[0] ?>, <?php echo $end[1] ?>, 0)],

                        <?php endforeach ?>
                    <?php endforeach ?>
                <?php endforeach ?>

                <?php
                    foreach ($other_courses_periodss as $other_courses_periods) :
                        foreach ($other_courses_periods as $other_courses_period) :
                            foreach ($other_courses_period as $day => $value) :
                                foreach ($other_courses_period->$day as $co => $value2) :
                                    if (!array_search($co, $my_couses_array)) :
                                        $start = explode(':', $other_courses_period->$day->$co->start);
                                        $end = explode(':', $other_courses_period->$day->$co->end);
                    ?>

                                        ['<?php echo $day ?>', '<?php echo $co . " ({$other_courses_period->$day->$co->venue})" ?>', new Date(0, 0, 0, <?php echo $start[0] ?>, <?php echo $start[1] ?>, 0), new Date(0, 0, 0, <?php echo $end[0] ?>, <?php echo $end[1] ?>, 0)],
                                    <?php endif ?>
                                <?php endforeach ?>
                            <?php endforeach ?>
                        <?php endforeach ?>
                    <?php endforeach ?>




                    <?php
                    foreach ($gst_periodss as $gst_periods) :
                        foreach ($gst_periods as $day => $value) :
                            foreach ($gst_periods->$day as $co => $value2) :

                                $start = explode(':', $gst_periods->$day->$co->start);
                                $end = explode(':', $gst_periods->$day->$co->end);
                    ?>

                                ['<?php echo $day ?>', '<?php echo $co . " ({$gst_periods->$day->$co->venue})" ?>', new Date(0, 0, 0, <?php echo $start[0] ?>, <?php echo $start[1] ?>, 0), new Date(0, 0, 0, <?php echo $end[0] ?>, <?php echo $end[1] ?>, 0)],

                            <?php endforeach ?>
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