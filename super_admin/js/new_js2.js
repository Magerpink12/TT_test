$(document).ready(function(){

    

// populating update department modal
    $('.dept-edit-modal').click(function(){
        // $('#head').prop('id')
        var id = $(this).attr('data')
        // console.log(id)
        // $('#head').text(id)
        
        $.ajax({
            method:"GET",
            url: 'include/action/department_ajax.php?id='+id,
            success:function(data){
                var data =JSON.parse(data)
                console.log(data)

                $("form[name='edit-dept']").find("input[name='name']").val(data.name)
                $("form[name='edit-dept']").find("[name='faculty']").val(data.faculty)
                $("form[name='edit-dept']").find("[name='max_level_range']").val(data.max_level_range)
                $("[name='dept_id']").val(data.id)
            },
            beforeSend:function(){

            }

        })

    })

// adding department
    $('#add-dept').click(function(){
        
        var name = $("form[name='add-dept']").find("input[name='name']").val()
        var faculty = $("form[name='add-dept']").find("[name='faculty']").val()
        var max_level_range = $("form[name='add-dept']").find("[name='max_level_range']").val()
        
        if(name==''){
            $('#add-dept-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
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
        }else if(faculty==''){
            $('#add-dept-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="alert-icon">
                            <i class="far fa-fw fa-bell"></i>
                        </div>
                        <div class="alert-message">
                            <strong>Faculty </strong>Field cannot be Empty!
                        </div>
                        </div>'`)
                        return false
        }

        var data = {
            add_dept: true,
            name,
            faculty,
            max_level_range
        }
        console.log(data)

        $.ajax({
            method:'POST',
            url:'include/action/department_ajax.php',
            data: data,
            success: function(data){
                console.log(data)
                var as = data.search('Error')
                console.log(as)
                if(as !=-1){
                    $('#add-dept-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="alert-icon">
                        <i class="far fa-fw fa-bell"></i>
                    </div>
                    <div class="alert-message">
                        <strong>department Already Existed! </strong>!
                    </div>
                    </div>'`)
                    return false
                }else{
                window.location.href ='index.php?page=dept'

                }
            },

        })

    })


// Updating department
    $('#edit-dept').click(function(){

        var name = $("form[name='edit-dept']").find("input[name='name']").val()
        var faculty = $("form[name='edit-dept']").find("[name='faculty']").val()
        var max_level_range = $("form[name='edit-dept']").find("[name='max_level_range']").val()
        var id = $("[name='dept_id']").val()

        if(name==''){
            $('#edit-dept-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
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
        }else if(faculty==''){
            $('#edit-dept-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="alert-icon">
                            <i class="far fa-fw fa-bell"></i>
                        </div>
                        <div class="alert-message">
                            <strong>Faculty </strong>Field cannot be Empty!
                        </div>
                        </div>'`)
                        return false
        }

        var data = {
            update_dept: true,
            name,
            faculty,
            max_level_range,
            id
        }
        console.log(data)

        $.ajax({
            method:'POST',
            url:'include/action/department_ajax.php',
            data: data,
            success: function(data){
                var as = data.search('Error')
                console.log(as)
                if(as !=-1){
                    $('#edit-dept-error').html(`<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="alert-icon">
                        <i class="far fa-fw fa-bell"></i>
                    </div>
                    <div class="alert-message">
                        <strong>department Already Existed! </strong>!
                    </div>
                    </div>'`)
                    // console.log('hahahah')
                    return false
                }else{
                window.location.href ='index.php?page=dept'

                }
            },

        })

    })


// delete




  
})  