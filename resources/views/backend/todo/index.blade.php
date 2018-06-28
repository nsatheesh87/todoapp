@extends ('backend.layouts.app')

@section ('title', app_name() . ' | Task Management')


@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                   Task Management
                </h4>
            </div><!--col-->

            <div class="col-sm-7">
                @include('backend.todo.includes.header-buttons')
            </div><!--col-->
        </div><!--row-->

        <div class="row mt-4">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Created By</th>
                            <th>Created on</th>
                            <th>Last updated</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->description }}</td>
                                <td>{{ $task->user->first_name }} {{ $task->user->last_name }}</td>
                                <td>{{ $task->created_at->diffForHumans() }}</td>
                                <td>{{ $task->updated_at->diffForHumans() }}</td>
                                <td><a href="{{route('admin.todotask.edit', $task->id)}}"> <span class="fa fa-edit"> </span> </a>&nbsp;
                                    <a data-method="delete" data-trans-button-cancel="Cancel" data-trans-button-confirm="Delete" data-trans-title="Are you sure you want to do this?" class="" style="cursor:pointer;" onclick="$(this).find(&quot;form&quot;).submit();">
                                        <span class="fa fa-trash"> </span>
                                        <form action="{{route('admin.todotask.destroy', $task->id)}}" method="POST" name="delete_item" style="display:none">
                                            <input type="hidden" name="_method" value="delete">
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        </form>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div><!--col-->
        </div><!--row-->
        <div class="row">
            <div class="col-7">
                <div class="float-left">
                    {!! $tasks->total() !!} {{ trans_choice('', $tasks->total()) }} Tasks
                </div>
            </div><!--col-->

            <div class="col-5">
                <div class="float-right">
                    {!! $tasks->render() !!}
                </div>
            </div><!--col-->
        </div><!--row-->
    </div><!--card-body-->
</div><!--card-->
@endsection
