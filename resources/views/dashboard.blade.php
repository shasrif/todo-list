<!Doctype HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>To-Do List login page</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    </head>
    <body>
        <input type="hidden" id="get_token" value="{{session('token')}}">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-bottom: 30px">
                <a class="navbar-brand" href="javascript:;">To-Do List</a>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ session('user_name') }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="javascript:;" class="btn_logout">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="row">
                <div class="col-lg-12">
                    <h2 style="float:left">To-Do List</h2>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTaskModal" style="float:right">Add new tasks</button>
                    @if($todo)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Task ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">Added by</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="load-ajax-posts">
                                @foreach($todo as $row)
                                <tr class="post-row-{{$row->id}}">
                                    <th scope="row">{{ $row->id }}</th>
                                    <td>{{ $row->title }}</td>
                                    <td>{{ $row->body }}</td>
                                    <td>{{ $row->user->name }}</td>
                                    <td class="status-{{$row->id}}">{!! $row->status == 0 ? '<a class="btn btn-info" href="javascript:;" onClick="change_status('.$row->id.', '.$row->status.')">Pending</a>' : '<a class="btn btn-info" href="javascript:;" onclick="change_status('.$row->id.', '.$row->status.')">Completed</a>' !!}</td>
                                    <td>
                                        <a class="btn btn-primary" href="javascript:;" onClick="todo_edit({{ $row->id }})">Edit</a>
                                        <a class="btn btn-danger" href="javascript:;" onClick="todo_delete({{ $row->id }})">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <!-- Add new tasks -->
        <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form id="post-form" method="post">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addTaskModalLabel">Add new task</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
                            </div>
                            <div class="form-group">
                                <label for="body">Content</label>
                                <textarea class="form-control" id="body" name="body" placeholder="Enter content"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary btn-post">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- edit tasks -->
        <div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form id="post-update-form" method="PUT">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editTaskModalLabel">Edit task</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body pust-edit-task">
                            
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button class="btn btn-primary btn-post-update">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/js/script.js') }}"></script>
    </body>
</html>