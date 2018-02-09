<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>To Do List Web Application</title>

    <!-- Load Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <!-- Load Custom CSS -->
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
</head>
<body>
    <div class="container-narrow">
        <div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th colspan="7"><h2>To Do List <span><button id="btn-add" name="btn-add" class="btn btn-primary btn-sm">Add New Record</button></span></h2></th>
                    </tr>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Note</th>
                        <th scope="col">Due Date</th>
                        <th scope="col">Actions</th>
                        <th scope="col">Due Notice</th>
                    </tr>
                </thead>
                <tbody id="tasks-list" name="tasks-list">
                    @foreach ($tasks as $task)
                        <?php 
                            if($task->due_date < date('Y-m-d'))
                            {
                                $style = 'alert alert-danger'; 
                                $due_notice = "Overdue";
                            }
                            else if ($task->due_date == date('Y-m-d'))
                            {
                                $style = 'alert alert-warning';
                                $due_notice = "Due Today";     
                            }
                            else
                            {
                                $startTimeStamp = strtotime($task->due_date);
                                $endTimeStamp = strtotime(date('Y-m-d'));

                                $timeDiff = abs($endTimeStamp - $startTimeStamp);

                                $numberDays = $timeDiff/86400;  // 86400 seconds in one day

                                // and you might want to convert to integer
                                $numberDays = intval($numberDays);
                                $style = 'alert alert-success'; 
                                $due_notice = "Due in " .strval($numberDays). " days";   
                            }

                        ?>
                    <tr id="task{{$task->id}}" class="{{$style}}">
                        <td scope="row">{{$task->id}}</td>
                        <td>{{$task->title}}</td>
                        <td>{{$task->description}}</td>
                        <td>{{$task->note}}</td>
                        <td>{{$task->due_date}}</td>
                        <td>
                            <button class="btn btn-default btn-sm btn-detail open-modal" value="{{$task->id}}">Edit</button>
                            <button class="btn btn-danger btn-sm btn-delete delete-task" value="{{$task->id}}">Delete</button>
                        </td>
                        <td>{{$due_notice}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">Task Editor</h4>
                        </div>
                        <div class="modal-body">
                            <form id="frmTasks" name="frmTasks" class="form-horizontal" novalidate="">

                                <div class="form-group error">
                                    <label for="title" class="col-sm-3 control-label">Task</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control has-error" id="title" name="title" placeholder="Task" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description" class="col-sm-3 control-label">Description</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="description" class="col-sm-3 control-label">Note (Optional)</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="note" name="note" placeholder="Note (Optional)" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="due_date" class="col-sm-3 control-label">Due Date</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control" id="due_date" name="due_date"  value="<?php echo date('Y-m-d'); ?>" required>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes</button>
                            <input type="hidden" id="task_id" name="task_id" value="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <meta name="_token" content="{!! csrf_token() !!}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="{{asset('js/ajax.js')}}"></script>
</body>
</html>