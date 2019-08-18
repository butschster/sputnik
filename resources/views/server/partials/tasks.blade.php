<div class="card mt-3">
    <div class="card-header">
        <i class="fas fa-tasks fa-lg mr-3"></i> Server tasks
    </div>

    <table class="table table-hover mb-0">
        <col>
        <col width="100px">
        @foreach($tasks as $task)
            <tr>
                <td>
                    <small class="badge">{{ $task->created_at }}</small>
                    <a href="{{ route('task.show', $task) }}"><strong>{{ $task->name }}</strong></a>
                </td>
                <td class="text-right">
                    <span class="badge badge-dark">{{ $task->status }}</span>
                </td>
            </tr>
        @endforeach
    </table>
</div>
