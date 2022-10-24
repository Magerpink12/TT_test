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





    // populating update venue modal
    $('.venue-edit-modal').click(function () {
        // $('#head').prop('id')
        var id = $(this).attr('data')
        // console.log(id)
        // $('#head').text(id)

        $.ajax({
            method: "GET",
            url: 'include/action/venue_ajax.php?id=' + id,
            success: function (data) {
                var data = JSON.parse(data)
                console.log(data)

                $("form[name='edit-venue']").find("input[name='name']").val(data.name)
                $("form[name='edit-venue']").find("[name='capacity']").val(data.capacity)
                $("form[name='edit-venue']").find("[name='department']").val(data.department)
                $("form[name='edit-venue']").find("[name='venue_id']").val(data.id)
            },
            beforeSend: function () {

            }

        })

    })

    // adding venue
    $('#add-venue').click(function () {

        var name = $("form[name='add-venue']").find("input[name='name']").val()
        var capacity = $("form[name='add-venue']").find("[name='capacity']").val()
        var department = $("form[name='add-venue']").find("[name='department']").val()
        
        var message = ''
        var error_count = 0

        if (name == '') {
            error_count++
            message += notification('danger', '<strong>venue Name </strong>Field cannot be Empty!') + "<br>"
        } else if (capacity == '') {
            error_count++
            message += notification('danger', '<strong>Capacity </strong>Field cannot be Empty!') + "<br>"

        } else if (department == '') {
            error_count++
            message += notification('danger', '<strong>Department </strong>Field cannot be Empty!') + "<br>"
        }

        if (error_count != 0) {
            $('#add-venue-error').html(message)

            return false

        }

        var data = {
            add_venue: true,
            capacity,
            department,
            name
        }
        console.log(data)

        $.ajax({
            method: 'POST',
            url: 'include/action/venue_ajax.php',
            data: data,
            success: function (data) {
                console.log(data)
                var as = data.search('Error')
                console.log(as)
                if (as != -1) {

                    var message = notification('danger', '<strong>Venue </strong> Already Existed!!') + "<br>"
                    $('#add-venue-error').html(message)

                    return false
                } else {
                    window.location.href = 'index.php?page=venues'

                }
            },

        })

    })


    // // Updating Venue
    $('#edit-venue').click(function () {

        var name = $("form[name='edit-venue']").find("input[name='name']").val()
        var capacity = $("form[name='edit-venue']").find("[name='capacity']").val()
        var department = $("form[name='edit-venue']").find("[name='department']").val()
        var id = $("form[name='edit-venue']").find("[name='venue_id']").val()
        
        var message = ''
        var error_count = 0

        if (name == '') {
            error_count++
            message += notification('danger', '<strong>venue Name </strong>Field cannot be Empty!') + "<br>"
        } else if (capacity == '') {
            error_count++
            message += notification('danger', '<strong>Capacity </strong>Field cannot be Empty!') + "<br>"

        } 
        else if (department == '') {
            error_count++
            message += notification('danger', '<strong>Department </strong>Field cannot be Empty!') + "<br>"
        }
        else if (id == '') {
            error_count++
            message += notification('danger', '<strong>Department </strong>Error!') + "<br>"
        }

        if (error_count != 0) {
            $('#edit-venue-error').html(message)

            return false

        }

        var data = {
            update_venue: true,
            capacity,
            department,
            name,
            id
        }
        console.log(data)


        $.ajax({
            method: 'POST',
            url: 'include/action/venue_ajax.php',
            data: data,
            success: function (data) {
                var as = data.search('Error')
                console.log(as)
                if (as != -1) {
                    $('#edit-venue-error').html(notification('danger','department Already Existed!'))
                 
                    return false
                } else {
                    window.location.href = 'index.php?page=venues'

                }
            },

        })

    })


})