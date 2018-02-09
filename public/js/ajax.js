$(document).ready(function(){

    var url = "/tasks";

    //display modal form for task editing
    $('#tasks-list').on('click', '.open-modal',function(){ 
        var task_id = $(this).val();

        $.get(url + '/' + task_id, function (data) {
            //success data
            console.log(data);
            $('#task_id').val(data.id);
            $('#title').val(data.title);
            $('#description').val(data.description);
            $('#note').val(data.note);
            $('#due_date').val(data.due_date);
            $('#btn-save').val("update");

            $('#myModal').modal('show');
        }) 
    });

    //display modal form for creating new task
    $('#btn-add').click(function(){
        $('#btn-save').val("add");
        $('#frmTasks').trigger("reset");
        $('#myModal').modal('show');
    });

    //delete task and remove it from list
    $('#tasks-list').on("click", ".delete-task", function () {

        var task_id = $(this).val();
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

            }

        });

        $.ajax({

            type: "DELETE",

            url: url + '/' + task_id,

            success: function (data) {

            console.log(data);

            $("#task" + task_id).remove();

        },

        error: function (data) {

            console.log('Error:', data);

        }

        });

    });

    //create new task / update existing task
    $("#btn-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        e.preventDefault(); 

        var formData = {
            title: $('#title').val(),
            description: $('#description').val(),
            note: $('#note').val(),
            due_date: $('#due_date').val(),
        }

        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();

        var type = "POST"; //for creating new resource
        var task_id = $('#task_id').val();;
        var my_url = url;

        if (state == "update"){
            type = "PUT"; //for updating existing resource
            my_url += '/' + task_id;
        }

        console.log(formData);

        $.ajax({

            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                /*
                var task = '<tr id="task' + data.id + '"><td>' + data.id + '</td><td>' + data.title + '</td><td>' + data.description + '</td><td>' + data.note + '</td><td>' + data.due_date + '</td>';
                task += '<td><button class="btn btn-default btn-sm btn-detail open-modal" value="' + data.id + '">Edit</button>';
                task += '<button class="btn btn-danger btn-sm btn-delete delete-task" value="' + data.id + '">Delete</button></td></tr>';
                if (state == "add"){ //if user added a new record
                    $('#tasks-list').append(task);
                }else{ //if user updated an existing record

                    $("#task" + task_id).replaceWith( task );
                }
                */

                $('#frmTasks').trigger("reset");

                $('#myModal').modal('hide')
                location.reload();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
});