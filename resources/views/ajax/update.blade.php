<th scope="row">{{ $row->id }}</th>
<td>{{ $row->title }}</td>
<td>{{ $row->body }}</td>
<td>{{ $row->user->name }}</td>
<td class="status-{{$row->id}}">{!! $row->status == 0 ? '<a class="btn btn-info" href="javascript:;" onClick="change_status('.$row->id.', '.$row->status.')">Pending</a>' : '<a class="btn btn-info" href="javascript:;" onclick="change_status('.$row->id.', '.$row->status.')">Completed</a>' !!}</td>
<td>
    <a class="btn btn-primary" href="javascript:;" onClick="todo_edit({{ $row->id }})">Edit</a>
    <a class="btn btn-danger" href="javascript:;" onClick="todo_delete({{ $row->id }})">Delete</a>
</td>