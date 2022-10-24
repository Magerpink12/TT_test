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
                                // console.log(cos)
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
