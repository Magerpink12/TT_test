$(document).ready(function () {

    function notification(type, msg) {

        var message = `<div class="alert alert-` + type + ` alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="alert-icon">
            <i class="far fa-fw fa-bell"></i>
        </div>
        <div class="alert-message">
            ` + msg + `
        </div>
        </div>`

        return message
    }





    // // populating update department modal
    $('.course-edit-modal').click(function () {
        // $('#head').prop('id')
        var id = $(this).attr('data')
        // console.log(id)
        // $('#head').text(id)

        $.ajax({
            method: "GET",
            url: 'include/action/course_ajax.php?id=' + id,
            success: function (data) {
                var data = JSON.parse(data)
                console.log(data)

                $("form[name='edit-course']").find("input[name='code']").val(data.course_code)
                $("form[name='edit-course']").find("[name='title']").val(data.title)
                $("form[name='edit-course']").find("[name='unit']").val(data.unit)
                $("form[name='edit-course']").find("[name='level']").val(data.level)
                $("form[name='edit-course']").find("[name='semester']").val(data.semester)
                $("form[name='edit-course']").find("[name='department']").val(data.department)
                $("form[name='edit-course']").find("[name='course_id']").val(data.id)
            },
            beforeSend: function () {

            }

        })

    })

    // adding department
    $('#add-course').click(function () {

        var code = $("form[name='add-course']").find("input[name='code']").val()
        var title = $("form[name='add-course']").find("[name='title']").val()
        var unit = $("form[name='add-course']").find("[name='unit']").val()
        var level = $("form[name='add-course']").find("[name='level']").val()
        var semester = $("form[name='add-course']").find("[name='semester']").val()
        var department = $("form[name='add-course']").find("[name='department']").val()
        var message = ''
        var error_count = 0

        if (code == '') {
            error_count++
            message += notification('danger', '<strong>Course Code </strong>Field cannot be Empty!') + "<br>"
        } else if (title == '') {
            error_count++
            message += notification('danger', '<strong>Title </strong>Field cannot be Empty!') + "<br>"

        } else if (unit == '') {
            error_count++
            message += notification('danger', '<strong>Unit </strong>Field cannot be Empty!') + "<br>"
        } else if (level == '') {
            error_count++
            message += notification('danger', '<strong>Level </strong>Field cannot be Empty!') + "<br>"
        } else if (semester == '') {
            error_count++
            message += notification('danger', '<strong>Semester </strong>Field cannot be Empty!') + "<br>"
        } else if (department == '') {
            error_count++
            message += notification('danger', '<strong>Department </strong>Field cannot be Empty!') + "<br>"
        }

        if (error_count != 0) {
            $('#add-course-error').html(message)

            return false

        }

        var data = {
            add_course: true,
            code,
            title,
            unit,
            level,
            semester,
            department
        }
        console.log(data)

        $.ajax({
            method: 'POST',
            url: 'include/action/course_ajax.php',
            data: data,
            success: function (data) {
                console.log(data)
                var as = data.search('Error')
                console.log(as)
                if (as != -1) {

                    var message = notification('danger', '<strong> Course </strong> Already Existed!!') + "<br>"
                    $('#add-course-error').html(message)

                    return false
                } else {
                    window.location.href = 'index.php?page=courses'

                }
            },

        })

    })


    // // Updating department
    $('#edit-course').click(function () {

        var code = $("form[name='edit-course']").find("input[name='code']").val()
        var title = $("form[name='edit-course']").find("[name='title']").val()
        var unit = $("form[name='edit-course']").find("[name='unit']").val()
        var level = $("form[name='edit-course']").find("[name='level']").val()
        var semester = $("form[name='edit-course']").find("[name='semester']").val()
        var department = $("form[name='edit-course']").find("[name='department']").val()
        var id = $("form[name='edit-course']").find("[name='course_id']").val()
        var message = ''
        var error_count = 0


        if (code == '') {
            error_count++
            message += notification('danger', '<strong>Course Code </strong>Field cannot be Empty!') + "<br>"
        } else if (title == '') {
            error_count++
            message += notification('danger', '<strong>Title </strong>Field cannot be Empty!') + "<br>"

        } else if (unit == '') {
            error_count++
            message += notification('danger', '<strong>Unit </strong>Field cannot be Empty!') + "<br>"
        } else if (level == '') {
            error_count++
            message += notification('danger', '<strong>Level </strong>Field cannot be Empty!') + "<br>"
        } else if (semester == '') {
            error_count++
            message += notification('danger', '<strong>Semester </strong>Field cannot be Empty!') + "<br>"
        } else if (department == '') {
            error_count++
            message += notification('danger', '<strong>Department </strong>Field cannot be Empty!') + "<br>"
        }else if (id == '') {
            error_count++
            message += notification('danger', '<strong>Department </strong>Field cannot be Empty!') + "<br>"
        }

        if (error_count != 0) {
            $('#edit-course-error').html(message)

            return false

        }
        var data = {
            update_course: true,
            code,
            title,
            unit,
            level,
            semester,
            department,
            id
        }
        console.log(data)

        $.ajax({
            method: 'POST',
            url: 'include/action/course_ajax.php',
            data: data,
            success: function (data) {
                var as = data.search('Error')
                console.log(as)
                if (as != -1) {
                    $('#edit-course-error').html(notification('danger','department Already Existed!'))
                 
                    return false
                } else {
                    window.location.href = 'index.php?page=courses'

                }
            },

        })

    })


    // delete





})