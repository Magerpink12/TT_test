$(document).ready(function(){

// populating update coordinator modal
    
    $('.edit').click(function(){
        // $('#head').prop('id')
        var id = $(this).attr('data')
        // console.log(id)
        $('#head').text(id)
        
        $.ajax({
            method:"GET",
            url: 'include/action/edit_coordinator.php?id='+id,
            success:function(data){
                var data =JSON.parse(data)

                console.log(data)

        $("form[name='edit']").find("[name='name']").val(data.name)
        $("form[name='edit']").find("[name='title']").val(data.title) 
        $("form[name='edit']").find("input[name='email']").val(data.email) 
        $("form[name='edit']").find("input[name='phone']").val(data.phone) 
        // $("form[name='edit']").find("[name='faculty']").val(data.faculty)
        $("form[name='edit']").find("[name='department']").val(data.department)
        $("form[name='edit']").find("input[name='username']").val(data.username)
        $("form[name='edit']").find("input[name='password']").val(data.password)
        $("form[name='edit']").find("[name='coordinate']").val(data.coordinate)
        $("input[name='user_id']").val(data.id)


        

            },
            beforeSend:function(){
                // alert()
                // return false

            }

        })

    })

// updating co-ordinator's infor

    $('#update').click(function(){

        var name = $("form[name='edit']").find("[name='name']").val()
        var title = $("form[name='edit']").find("[name='title']").val() 
        var email = $("form[name='edit']").find("input[name='email']").val() 
        var phone = $("form[name='edit']").find("input[name='phone']").val() 
        // var faculty = $("form[name='edit']").find("[name='faculty']").val()
        var department = $("form[name='edit']").find("[name='department']").val()
        var username = $("form[name='edit']").find("input[name='username']").val()
        var password = $("form[name='edit']").find("input[name='password']").val()
        var coordinate = $("form[name='edit']").find("[name='coordinate']").val()
        var user_id = $("input[name='user_id']").val()

        if(name==''){
            $('#edit-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="alert-icon">
                            <i class="far fa-fw fa-bell"></i>
                        </div>
                        <div class="alert-message">
                            <strong>Name </strong>Field cannot be Empty!
                        </div>
                        </div>'`)
                        return false
        }else if(phone==''){
            $('#edit-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="alert-icon">
                            <i class="far fa-fw fa-bell"></i>
                        </div>
                        <div class="alert-message">
                            <strong>Phone </strong>Field cannot be Empty!
                        </div>
                        </div>'`)
                        return false

        }
        // else if(faculty==''){
        //     $('#edit-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
        //                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        //                     <span aria-hidden="true">&times;</span>
        //                 </button>
        //                 <div class="alert-icon">
        //                     <i class="far fa-fw fa-bell"></i>
        //                 </div>
        //                 <div class="alert-message">
        //                     <strong>Faculty </strong>Field cannot be Empty!
        //                 </div>
        //                 </div>'`)
        //                 return false
        // }
        else if(department==''){
            $('#edit-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="alert-icon">
                            <i class="far fa-fw fa-bell"></i>
                        </div>
                        <div class="alert-message">
                            <strong>Department </strong>Field cannot be Empty!
                        </div>
                        </div>'`)
                        return false
        }else if(username==''){
            $('#edit-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="alert-icon">
                            <i class="far fa-fw fa-bell"></i>
                        </div>
                        <div class="alert-message">
                            <strong>Username </strong>Field cannot be Empty!
                        </div>
                        </div>'`)
                        return false
        }else if(password==''){
            $('#edit-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="alert-icon">
                            <i class="far fa-fw fa-bell"></i>
                        </div>
                        <div class="alert-message">
                            <strong>Password </strong>Field cannot be Empty!
                        </div>
                        </div>'`)
                        return false
        }else if(coordinate==''){
            $('#edit-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="alert-icon">
                            <i class="far fa-fw fa-bell"></i>
                        </div>
                        <div class="alert-message">
                            <strong>Coordinate </strong>Field cannot be Empty!
                        </div>
                        </div>'`)
                        return false
        }

        var data = {
            update: true,
            name,
            title,
            email,
            phone,
            // faculty,
            department,
            username,
            password,
            user_id,
            coordinate,
        }
        console.log(data)

        $.ajax({
            method:'POST',
            url:'include/action/edit_coordinator.php',
            data: data,
            success: function(data){
                window.location.href ='index.php?page=co-ordinators'
            },

        })

    })





// adding coordinator
    $('#add-co').click(function(){

        var name = $("form[name='add-co']").find("[name='name']").val()
        var title = $("form[name='add-co']").find("[name='title']").val() 
        var email = $("form[name='add-co']").find("input[name='email']").val() 
        var phone = $("form[name='add-co']").find("input[name='phone']").val() 
        // var faculty = $("form[name='add-co']").find("[name='faculty']").val()
        var department = $("form[name='add-co']").find("[name='department']").val()
        var username = $("form[name='add-co']").find("input[name='username']").val()
        var password = $("form[name='add-co']").find("input[name='password']").val()
        var coordinate = $("form[name='add-co']").find("[name='coordinate']").val()

        if(name==''){
            $('#add-co-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="alert-icon">
                            <i class="far fa-fw fa-bell"></i>
                        </div>
                        <div class="alert-message">
                            <strong>Name </strong>Field cannot be Empty!
                        </div>
                        </div>'`)
                        return false
        }else if(phone==''){
            $('#add-co-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="alert-icon">
                            <i class="far fa-fw fa-bell"></i>
                        </div>
                        <div class="alert-message">
                            <strong>Phone </strong>Field cannot be Empty!
                        </div>
                        </div>'`)
                        return false

        }
        // else if(faculty==''){
        //     $('#add-co-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
        //                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        //                     <span aria-hidden="true">&times;</span>
        //                 </button>
        //                 <div class="alert-icon">
        //                     <i class="far fa-fw fa-bell"></i>
        //                 </div>
        //                 <div class="alert-message">
        //                     <strong>Faculty </strong>Field cannot be Empty!
        //                 </div>
        //                 </div>'`)
        //                 return false
        // }
        else if(department==''){
            $('#add-co-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="alert-icon">
                            <i class="far fa-fw fa-bell"></i>
                        </div>
                        <div class="alert-message">
                            <strong>Department </strong>Field cannot be Empty!
                        </div>
                        </div>'`)
                        return false
        }else if(username==''){
            $('#add-co-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="alert-icon">
                            <i class="far fa-fw fa-bell"></i>
                        </div>
                        <div class="alert-message">
                            <strong>Username </strong>Field cannot be Empty!
                        </div>
                        </div>'`)
                        return false
        }else if(password==''){
            $('#add-co-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="alert-icon">
                            <i class="far fa-fw fa-bell"></i>
                        </div>
                        <div class="alert-message">
                            <strong>Password </strong>Field cannot be Empty!
                        </div>
                        </div>'`)
                        return false
        }else if(coordinate==''){
            $('#edit-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="alert-icon">
                            <i class="far fa-fw fa-bell"></i>
                        </div>
                        <div class="alert-message">
                            <strong>Coordinate </strong>Field cannot be Empty!
                        </div>
                        </div>'`)
                        return false
        }

        var data = {
            add_co: true,
            name,
            title,
            email,
            phone,
            // faculty,
            department,
            username,
            password,
            coordinate,
        }
        console.log(data)

        $.ajax({
            method:'POST',
            url:'include/action/edit_coordinator.php',
            data: data,
            success: function(data){
                console.log(data)
                window.location.href ='index.php?page=co-ordinators'
            },

        })

    })

// populating update faculty modal
    $('.fac-edit-modal').click(function(){
        // $('#head').prop('id')
        var id = $(this).attr('data')
        // console.log(id)
        // $('#head').text(id)
        
        $.ajax({
            method:"GET",
            url: 'include/action/faculty_ajax.php?id='+id,
            success:function(data){
                var data =JSON.parse(data)
                console.log(data)

                $("form[name='edit_fac']").find("input[name='name']").val(data.name)
                $("input[name='fac_id']").val(data.id)
            },
            beforeSend:function(){
                // alert()
                // return false

            }

        })

    })

// adding faculty
    $('#add-fac').click(function(){

        var name = $("form[name='add-fac']").find("input[name='name']").val()

        if(name==''){
            $('#add-fac-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="alert-icon">
                            <i class="far fa-fw fa-bell"></i>
                        </div>
                        <div class="alert-message">
                            <strong>Name </strong>Field cannot be Empty!
                        </div>
                        </div>'`)
                        return false
        }

        var data = {
            add_fac: true,
            name,
        }
        console.log(data)

        $.ajax({
            method:'POST',
            url:'include/action/faculty_ajax.php',
            data: data,
            success: function(data){
                var as = data.search('Error')
                console.log(as)
                if(as !=-1){
                    $('#add-fac-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="alert-icon">
                        <i class="far fa-fw fa-bell"></i>
                    </div>
                    <div class="alert-message">
                        <strong>Faculty Already Existed! </strong>!
                    </div>
                    </div>'`)
                    return false
                }else{
                window.location.href ='index.php?page=faculty'

                }
            },

        })

    })


// Updating faculty
    $('#edit-fac').click(function(){

        var name = $("form[name='edit_fac']").find("[name='name']").val()
        var fac_id = $("input[name='fac_id']").val()

        if(name==''){
            $('#edit-fac-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="alert-icon">
                            <i class="far fa-fw fa-bell"></i>
                        </div>
                        <div class="alert-message">
                            <strong>Name </strong>Field cannot be Empty!
                        </div>
                        </div>'`)
                        return false
        }

        var data = {
            update_fac: true,
            name,
            fac_id,
        }
        console.log(data)

        $.ajax({
            method:'POST',
            url:'include/action/faculty_ajax.php',
            data: data,
            success: function(data){
                var as = data.search('Error')
                console.log(as)
                if(as !=-1){
                    $('#edit-fac-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="alert-icon">
                        <i class="far fa-fw fa-bell"></i>
                    </div>
                    <div class="alert-message">
                        <strong>Faculty Already Existed! </strong>!
                    </div>
                    </div>'`)
                    console.log('hahahah')
                    return false
                }else{
                window.location.href ='index.php?page=faculty'

                }
            },

        })

    })



  
})  