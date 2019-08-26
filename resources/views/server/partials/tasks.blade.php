<section class="mt-10">
    <h4>Server tasks</h4>

    <table class="table">
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
</section>
