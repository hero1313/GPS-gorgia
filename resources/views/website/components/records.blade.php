@extends('website.index')
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div>

            @include('website.layouts.navbar')
            <div class="mb-3 container-fluid">
                <form
                    class="my-2 mr-auto object-form d-none d-sm-inline-block form-inline ml-md-3 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="border-0 form-control bg-light small objects-search"
                            placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="p-3 btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <button class="btn btn-primary add-btn" data-toggle="modal" data-target="#add_record">დამატება</button>
            </div>
        </div>
        <div class="mb-3 container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="mb-4 shadow card">
                        <div class="py-3 card-header">
                            <h6 class="m-0 font-weight-bold text-primary">ჩექინები</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>შემსრულებელი</th>
                                            <th>დავალება</th>
                                            <th>ლოკაცია</th>
                                            <th>თარიღი</th>
                                            <th>დეტალები</th>
                                            <th>სურათი</th>
                                            <th>სტატუსი</th>
                                            <th>რედაქტირება</th>
                                            <th>წაშლა</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($records as $record)
                                            <tr>
                                                <td>{{ $record->assigned_user_id }}</td>
                                                <td>{{ $record->task_id }}</td>
                                                <td>{{ $record->location_id }} ქალაქი</td>
                                                <td>{{ $record->date }}</td>
                                                <td><button class="btn btn-primary" data-toggle="modal"
                                                    data-target="#record_detail_{{ $record->id }}">დეტალები</button>
                                                </td>
                                                <td><a href="{{ $record->image }}" target="_blank"><button class="btn btn-success">სურათი</button></a></td>
                                                
                                                <td><button class="btn btn-success">{{ $record->status }}</button></td>
                                                <td><button class="btn btn-primary" data-toggle="modal"
                                                        data-target="#record_edit_{{ $record->id }}">რედაქტირება</button>
                                                </td>
                                                <td><button class="btn btn-danger" data-toggle="modal"
                                                        data-target="#record_delete_{{ $record->id }}">წაშლა</button></td>
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


    @foreach ($records as $record)
        {{-- detail --}}
        <div class="modal fade" id="record_detail_{{ $record->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ჩანაწერის დეტალები</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-4 detail-map">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d9988.968530912382!2d44.81947456307118!3d41.69281785924005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40440d393e031453%3A0xa10cc4518e003f22!2sSheraton%20Grand%20Tbilisi%20Metechi%20Palace!5e0!3m2!1sen!2sge!4v1711963295898!5m2!1sen!2sge"
                                        width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <li class="d-flex">
                                    <h5 class="mr-3">Id :</h5>
                                    <p>{{ $record->id }}</p>
                                </li>
                                <li class="d-flex">
                                    <h5 class="mr-3">შემსრულებელი :</h5>
                                    <p>{{ $record->assigned_user_id }}</p>
                                </li>
                                <li class="d-flex">
                                    <h5 class="mr-3">თარიღი :</h5>
                                    <p>{{ $record->date }}</p>
                                </li>
                                <li class="d-flex">
                                    <h5 class="mr-3">შეზღუდვის დრო :</h5>
                                    <p>{{ $record->timer }}წთ</p>
                                </li>

                            </div>
                            <div class="col-12 col-md-6">
                                <li class="d-flex">
                                    <h5 class="mr-3">რადიუსი :</h5>
                                    <p>{{ $record->radius }} მეტრი</p>
                                </li>
                                <li class="d-flex">
                                    <h5 class="mr-3">ჩექინი :</h5>
                                    <p>{{ $record->check_in_time }}</p>
                                </li>
                                <li class="d-flex">
                                    <h5 class="mr-3">ჩექაუთი :</h5>
                                    <p>{{ $record->check_out_time }}</p>
                                </li>
                                <li class="d-flex">
                                    <h5 class="mr-3">სტატუსი :</h5>
                                    <p>{{ $record->status }}</p>
                                </li>
                            </div>
                            <div class="col-12 detail-line">
                                <li class="d-flex">
                                    <h5 class="mr-3">დავალება :</h5>
                                    <p>{{ $record->description }}</p>
                                </li>
                                <li class="d-flex">
                                    <h5 class="mr-3">კომენტარი :</h5>
                                    <p>{{ $record->comment }}</p>
                                </li>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- record edit modal --}}
        <div class="modal fade" id="record_edit_{{ $record->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form action="{{ route('records.update', $record->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">ჩექინის რედაქტირება</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="inputState">შემსრულებელი</label>
                                    <select id="inputState" name="assigned_user_id" required class="form-control">
                                        <option value="{{ $record->assigned_user_id }}">{{ $record->assigned_user_id }}
                                        </option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="inputState">დავალება</label>
                                    <select id="inputState" name="task_id" class="form-control">
                                        <option value="{{ $record->task_id }}">{{ $record->task_id }}</option>
                                        @foreach ($tasks as $task)
                                            <option value="{{ $task->id }}">{{ $task->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="inputState">ლოკაცია</label>
                                    <select id="inputState" name="location_id" class="form-control">
                                        <option value="{{ $record->location_id }}">{{ $record->location_id }}</option>
                                        @foreach ($locations as $location)
                                            <option value="{{ $location->id }}">{{ $location->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">თარიღი</label>
                                    <input type="date" name="date" class="form-control"
                                        value="{{ $record->date }}">
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

        {{-- record delete modal --}}
        <div class="modal fade" id="record_delete_{{ $record->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form action="{{ route('records.destroy', $task->id) }}" method="post">
                    @method('delete')
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">ჩექინის წაშლა</h5>
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


    {{-- add record modal --}}
    <div class="modal fade" id="add_record" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('records.store') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ჩექინის დამატება</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="inputState">შემსრულებელი</label>
                                <select id="inputState" name="assigned_user_id" required class="form-control">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="inputState">დავალება</label>
                                <select id="inputState" name="task_id" class="form-control">
                                    @foreach ($tasks as $task)
                                        <option value="{{ $task->id }}">{{ $task->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="inputState">ლოკაცია</label>
                                <select id="inputState" name="location_id" class="form-control">
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">თარიღი</label>
                                <input type="date" name="date" class="form-control" value="{{ $today }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">დახურვა</button>
                        <button type="submit" class="btn btn-primary">დამატება</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop
