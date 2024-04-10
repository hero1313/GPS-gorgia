@extends('website.index')
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div>
            @include('website.layouts.navbar')
            <div class="mb-3 container-fluid">
                <form method="get" action="{{ route('tasks.index') }}"
                    class="my-2 mr-auto object-form d-none d-sm-inline-block form-inline ml-md-3 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input name="search" type="text" class="border-0 form-control bg-light small objects-search"
                            placeholder="Search for..." value="{{ $request['search'] ?? '' }}">
                        <div class="input-group-append">
                            <button class="p-3 btn btn-primary" type="submit">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <button class="btn btn-primary add-btn" data-toggle="modal" data-target="#add_task">დამატება</button>
            </div>
        </div>
        <div class="mb-3 container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="mb-4 shadow card">
                        <div class="py-3 card-header">
                            <h6 class="m-0 font-weight-bold text-primary">იუზერები</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>დასახელება</th>
                                            <th>აღწერა</th>
                                            <th>რედაქტირება</th>
                                            <th>წაშლა</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tasks as $task)
                                            <tr>
                                                <th>{{ $task->id }}</th>
                                                <td>{{ $task->name }}</td>
                                                <td>{{ $task->description }}</td>
                                                <td><button class="btn btn-primary" data-toggle="modal"
                                                        data-target="#edit_task_{{ $task->id }}">რედაქტირება</button>
                                                </td>
                                                <td><button class="btn btn-danger" data-toggle="modal"
                                                        data-target="#delete_task_{{ $task->id }}">წაშლა</button></td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach ($tasks as $task)
        {{-- edit task --}}
        <div class="modal fade" id="edit_task_{{ $task->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <form action="{{ route('tasks.update', $task->id ) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">დავალების რედაქტირება</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">დასახელება</label>
                                    <input type="text" name="name" required class="form-control" value="{{ $task->name }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">აღწერა</label>
                                    <textarea type="text" name="description" class="form-control">{{ $task->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">დახურვა</button>
                        <button type="submit" class="btn btn-primary">დადასტურება</button>
                    </div>
                </div>
              </form>
            </div>
        </div>

        {{-- delete task --}}
        <div class="modal fade" id="delete_task_{{ $task->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <form action="{{ route('tasks.destroy',  $task->id ) }}" method="post">
                @method('delete')
                @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">დავალების წაშლა</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">დახურვა</button>
                            <button type="submit" class="btn btn-primary">წაშლა</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endforeach


    {{-- add task --}}
    <div class="modal fade" id="add_task" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <form action="{{ route('tasks.store') }}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ჩექინი</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">დასახელება</label>
                                <input type="text" name="name" required class="form-control" >
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">აღწერა</label>
                                <textarea type="text" name="description" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">დახურვა</button>
                    <button type="submit" class="btn btn-primary">დადასტურება</button>
                </div>
            </div>
          </form>
        </div>
    </div>
@stop
