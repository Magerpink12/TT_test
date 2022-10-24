<?php 
    $sql = "SELECT max_level_range FROM department WHERE name='{$user->department}'";
    $level = Department::find_by_query($sql);
    $level = intval($level[0]->max_level_range);

    $subcourse = Subscourse::find_by_query("SELECT * FROM subs_course WHERE department='{$user->department}'");
    // print_r($subcourse);

    if (empty($subcourse)) {
        
        for ($i=100; $i<= intval($level) ; $i= $i+100){
            $subcourses = new Subscourse();
            $subcourses->department = $user->department;
            $subcourses->level = $i;
            $subcourses->gst_courses = json_encode(array('First'=>[],'Second'=>[]));
            $subcourses->other_courses = json_encode(array('First'=>[],'Second'=>[]));
            $subcourses->create();
        }
        $subcourses;
    }

    
?>




<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">GST / Subsidiary Courses</h1>

        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Sessions</h5>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li><a href="#">2020</a>
                                <ul>
                                    <li><a href="#gst">First Semester</a></li>
                                    <li><a href="#">Semester Semester</a></li>
                                </ul>
                            </li>
                        </ul>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="insert session"
                                aria-label="Recipient's username" aria-describedby="basic-addon2">

                            <button class="input-group-text btn btn-primary" id="basic-addon2">Add Session</button>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Subsidiary Courses</h5>
                    </div>
                    <div class="card-body">

                        <datalist id="borrow">
                            <option selected>Select Course</option>
                            <?php $courses = Course::find_all();
                                    foreach ($courses as $course):
                                    ?>
                            <option value="<?php echo $course->course_code?>">
                                <?php echo $course->course_code . " - " . $course->title ?></option>
                            <?php endforeach ?>
                        </datalist>
                        <?php for ($i=100; $i<= intval($level) ; $i= $i+100):?>

                        <div>
                            <h5 class="mb-3 badge bg-info"><strong><?php echo $user->department?></strong> Department
                                <?php echo $i; ?> Level</h5>
                            <div class="input-group mb-3">
                                <input list="borrow" class="form-select" name="<?php echo $i; ?>_subscourse" placeholder="Select Course">

                                <span class="input-group-text" id="basic-addon2">Semester</span>

                                <select name="<?php echo $i; ?>_subssems" type="text" class="form-select"
                                    placeholder="Select Course">
                                    <option value="">Select Sem.</option>
                                    <option value="First">First Semester</option>
                                    <option value="Second">Second Semester</option>
                                </select>

                                <button level="<?php echo $i; ?>" class="input-group-text btn btn-primary addcourse"
                                    id="basic-addon2">Add Course</button>
                            </div>
                            <select name="<?php echo $i; ?>_subslist" style="background-color: #e9ecef;" multiple=""
                                class="form-control mb-2">
                            </select>
                            <button level="<?php echo $i; ?>" class="btn btn-danger btn-sm deletesubs"><i><svg
                                        width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-trash align-middle ">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                        </path>
                                    </svg></i> Remove</button>
                        </div>
                        <?php endfor?>
                    </div>
                </div>
            </div>











            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">General Studies Courses</h5>
                    </div>

                    <datalist id="gst">
                        <?php $gsts = Course::find_by_query("SELECT * FROM course WHERE semester='GST'");
                            foreach($gsts as $gst):
                        ?>
                        <option value="<?php echo $gst->course_code ?>">
                            <?php echo $gst->course_code . " - " . $gst->title ?></option>

                        <?php endforeach ?>

                    </datalist>

                    <div class="card-body">
                        <?php 
                        // echo $level;
                        for ($i=100; $i<= intval($level) ; $i= $i+100):
                            ?>

                        <!-- <input list="gst" class="form-control"> -->
                        <div>
                            <h5 class="mb-3 badge bg-info"><strong><?php echo $user->department?></strong> Department
                                <?php echo $i; ?>
                                Level</h5>
                            <div class="input-group mb-3">
                                <input list="gst" class="form-select" name="<?php echo $i; ?>_gstcourse" placeholder="Select Course">

                                <span class="input-group-text" id="basic-addon2">Semester</span>
                                
                                <select name="<?php echo $i; ?>_gstsems" type="text" class="form-select" placeholder="Select Course"
                                    aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <option value="">Select Sem.</option>
                                    <option value="First" >First Semester</option>
                                    <option value="Second">Second Semester</option>
                                </select>

                                <button level="<?php echo $i; ?>" class="input-group-text btn btn-primary addgstcourse" id="basic-addon2">Add GST</button>
                            </div>

                            <select name="<?php echo $i; ?>_gstlist" style="background-color: #e9ecef;" multiple="" class="form-control mb-2">
                              
                            </select>
                            <button level="<?php echo $i; ?>" class="btn btn-danger btn-sm deletegst"><i><svg width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-trash align-middle ">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                        </path>
                                    </svg></i> Remove</button>
                        </div>

                        <?php endfor ?>

                    </div>
                </div>


            </div>
        </div>

    </div>
</main>
<script>

// 

// REFERESHING FUNCTION DECLAIRATION

// 
function refresh_select(){
    $.ajax({
        method: "GET",
        url: "include/action/suplimentary_ajax.php?department=<?php echo $user->department ?>",
        success: function (data) {

            data = JSON.parse(data)
            // console.log(data)
            for (const levelindex in data) {

                if (Object.hasOwnProperty.call(data, levelindex)) {
                    const level = data[levelindex];

                    var other_courses = JSON.parse(level.other_courses)
                    var gst_courses = JSON.parse(level.gst_courses)

                    var selectsubs = $('[name="' + level.level + '_subslist"]')[0]
                    var selectgst = $('[name="' + level.level + '_gstlist"]')[0]
                    
                    selectsubs.innerHTML = ""
                    selectgst.innerHTML = ""

                    for (const semester in other_courses) {
                        if (Object.hasOwnProperty.call(other_courses, semester)) {

                            var semestercourses = other_courses[semester]

                            for (let index = 0; index < semestercourses.length; index++) {

                                const cos = semestercourses[index];
                                // console.log(cos)
                                selectsubs.innerHTML += `<option value='${level.level}/${semester}/${cos}'>${cos} (${semester} Semester)</option>`
                                // console.log(level.level, semester, cos)

                            }

                        }
                    }

                    for (const semester in gst_courses) {
                        if (Object.hasOwnProperty.call(gst_courses, semester)) {

                            var semestercourses = gst_courses[semester]

                            for (let index = 0; index < semestercourses.length; index++) {

                                const cos = semestercourses[index];
                                console.log(cos)
                                selectgst.innerHTML += `<option value='${level.level}/${semester}/${cos}'>${cos} (${semester} Semester)</option>`
                                // console.log(level.level, semester, cos)

                            }

                        }
                    }

                }
            }
        }
    })
}
refresh_select()

// 

// ADDING SUBSIDIARY COURSES

// 

    $('.addcourse').click(function () {
        var level = $(this).attr('level')
        var course = $('input[name="' + level + '_subscourse"]').val()
        var sems = $('[name="' + level + '_subssems"]').val()
        var department = "<?php echo $user->department ?>"

        if (course == '' || sems == '') {
            return false
        }

        var data = {
            add_subs: true,
            course,
            semester: sems,
            department,
            level
        }
        // console.log(data)
        var select = $('[name="' + level + '_subslist"]')[0]

        // console.log(select.innerHTML)

        var option = ""

        $.ajax({
            method: "POST",
            url: "include/action/suplimentary_ajax.php",
            data: data,
            success: function (data) {
                data = JSON.parse(data)
                for (const sems in data) {
                    if (Object.hasOwnProperty.call(data, sems)) {
                        const semscos = data[sems];

                        for (let index = 0; index < semscos.length; index++) {
                            const cos = semscos[index];

                            console.log(`${cos} = ${sems}`)
                            option +=
                                `<option value='${level}/${sems}/${cos}'>${cos} (${sems} Semester)</option>`
                        }
                    }
                }
                select.innerHTML = option
            }
        })
    })



// 

// DELETING SUBSIDIARY COURSES

// 


    $('.deletesubs').click(function () {
        var level = $(this).attr('level')
        var all = $('[name="' + level + '_subslist"]').val()

        
        if (all.length == 0) {
            return false
        }
      
        var data = {

        }
        for (let index = 0; index < all.length; index++) {
            const str = all[index];
            var ar = str.split('/')
            var level =ar[0]
            var course =ar[2]
            var semester =ar[1]


            data = {
               level,
               semester,
               course,
                department:"<?php echo $user->department ?>",
                del_subs: true
            }

        console.log(data)

         $.ajax({
            method: "POST",
            url: "include/action/suplimentary_ajax.php",
            data: data,
            success: function (data) {
                console.log(data)
                refresh_select()

            }
        })
        }

       
    })


// 

// ADDING GST COURSES

// 

    $('.addgstcourse').click(function () {
        var level = $(this).attr('level')
        var course = $('input[name="' + level + '_gstcourse"]').val()
        var sems = $('[name="' + level + '_gstsems"]').val()
        var department = "<?php echo $user->department ?>"

        if (course == '' || sems == '') {
            return false
        }

        var data = {
            add_subs: true,
            course,
            semester: sems,
            department,
            level,
            gst:true
        }
        // console.log(data)
        var select = $('[name="' + level + '_gstlist"]')[0]

        // console.log(select.innerHTML)

        var option = ""

        $.ajax({
            method: "POST",
            url: "include/action/suplimentary_ajax.php",
            data: data,
            success: function (data) {

                // console.log(data)
                // return false
                data = JSON.parse(data)
                for (const sems in data) {
                    if (Object.hasOwnProperty.call(data, sems)) {
                        const semscos = data[sems];

                        for (let index = 0; index < semscos.length; index++) {
                            const cos = semscos[index];

                            console.log(`${cos} = ${sems}`)
                            option +=
                                `<option value='${level}/${sems}/${cos}'>${cos} (${sems} Semester)</option>`
                        }
                    }
                }
                select.innerHTML = option
            }
        })
    })


// 

// DELETING GST COURSES

// 


    $('.deletegst').click(function () {
        var level = $(this).attr('level')
        var all = $('[name="' + level + '_gstlist"]').val()

        
        if (all.length == 0) {
            return false
        }
      
        var data = {

        }
        for (let index = 0; index < all.length; index++) {
            const str = all[index];
            var ar = str.split('/')
            var level =ar[0]
            var course =ar[2]
            var semester =ar[1]


            data = {
               level,
               semester,
               course,
                department:"<?php echo $user->department ?>",
                del_subs: true,
                gst: true
            }

        console.log(data)

         $.ajax({
            method: "POST",
            url: "include/action/suplimentary_ajax.php",
            data: data,
            success: function (data) {
                console.log(data)
                refresh_select()

            }
        })
        }

       
    })


</script>
<!-- <script src="js\subsidiary.js"></script> -->

