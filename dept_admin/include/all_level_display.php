<script>
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

<?php

$department = $user->department;
$semester = $_GET['semester'];

if ($semester == "second") {
    $semester = "Second";
}
if ($semester == "first") {
    $semester = "First";
}
if ($semester == "Second" || $semester == "First") {
} else {
    header("Location: ?page=manage_timetable");
}

$period = new Period();
$periods = $period->find_by_query("SELECT * FROM period WHERE department='{$user->department}' AND semester='{$semester}'");

$gst = Subscourse::find_subs_by_dept_and_level($user->department, '', $semester, 'gst');
$other_courses = Subscourse::find_subs_by_dept_and_level($user->department, '', $semester, 'other_courses');

$gst_periodss = Period::find_my_gst_periods('', $semester, $gst);

$other_courses_periodss = Period::find_my_subs_periods('', $semester, $other_courses);


?>

<main class="content">
    <div class="container-fluid p-0">
        <div class="row">


            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h6 class="h6 mb-3"><span class="card-title text-light">TIMETABLE For <?php echo $user->department . " (All Level {$semester} Semester)" ?></span><br>
                            <button style="background-color: #222e3c !important;" class="btn bg-primary"><a class="text-light" href="javascript:()" onclick="togglefullscreen()"><i class="align-middle" data-feather="external-link"></i>Full Screen</a></button>
                    </div>
                    <div class="card-body">
                        <div id='timetable_display' style='min-height:400px;'></div>
                    </div>
                    <div class="card-footer bg-dark">
                        <form action="print/print_timetable.php" method="post">
                            <input readonly type="hidden" value="<?php echo $user->faculty ?>" name="faculty" id="">
                            <input readonly type="hidden" value="<?php echo $user->department ?>" name="department" id="">
                            <input readonly type="hidden" value="<?php echo "All" ?>" name="level" id="">
                            <input readonly type="hidden" value="<?php echo $semester ?>" name="semester" id="">
                            <button style="background-color: #222e3c !important;" class="btn text-light" type="submit" name="print"><i class="align-middle" data-feather="download"></i>Print Timetable</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
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