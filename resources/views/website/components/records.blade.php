@extends('website.index')
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div>

            @include('website.layouts.navbar')
            <div class="mb-3 container-fluid">
                <form method="get" id="record_form" action="{{ route('records.index') }}"
                    class="my-2 navbar-search">
                    <div class="row filter">
                        <div class="col-12 col-md-2 input-group">
                        <input type="date" name="start_date" class="border-0 form-control bg-light small objects-search"
                            placeholder="თარიღი (დან)" value="{{ $request['start_date'] ?? '' }}">
                        </div>
                        <div class="col-12 col-md-2 input-group">
                            <input type="date" name="end_date" class="border-0 form-control bg-light small objects-search"
                                placeholder="თარიღი (მდე)" value="{{ $request['end_date'] ?? '' }}" >
                        </div>
                        <div class="col-12 col-md-2 input-group">
                            <select id="inputState" name="status" class="border-0 form-control bg-light small objects-search">
                                <option value="">სტატუსი</option>
                                <option value="0">დაგეგმილი</option>
                                <option value="1">დასრულებული</option>
                                <option value="2">ჩაშლილი</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-2 input-group">
                            <select id="inputState" name="assigned_user_id" class="border-0 form-control bg-light small objects-search">
                                <option value=" ">შემსრულებელი</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-2 input-group">
                            <select id="inputState" name="location_id" class="border-0 form-control bg-light small objects-search">
                                <option value=" ">ლოკაცია</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-2 input-group">
                            <button type="submit" id="filter_button" class="btn btn-primary ">გაფილტვრა</button>
                        </div>
                    </div>
                    
                <div class="d-flex">
                    <button class="btn btn-primary add-btn" type="button" data-toggle="modal" data-target="#add_record">დამატება</button>
                    <button class="ml-4 btn btn-success add-btn" id="excel_export">ექსელის ექსპორტი</button>
                </div>
            </form>

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
                                                <td>{{ $record->user ? $record->user->name : '' }}</td>
                                                <td>{{ $record->task ? $record->task->name : '' }}</td>
                                                <td>{{ $record->location ? $record->location->name : '' }}</td>
                                                <td>{{ $record->date }}</td>
                                                <td><button class="btn btn-primary edit_maps" data-toggle="modal"
                                                    data-target="#record_detail_{{ $record->id }}" id="map_btn_{{ $record->id }}"  data-lat="{{ $record->location->lat }}" data-lng="{{ $record->location->lng }}">დეტალები</button>
                                                </td>
                                                <td><a href="{{ $record->image }}" target="_blank"><button class="btn btn-success">სურათი</button></a></td>
                                                
                                                <td><button class="btn btn-success">
                                                @if($record->status == 0)
                                                    დაგეგმილი
                                                @elseif ($record->status == 1)
                                                    დასრულებული
                                                @else
                                                    ჩაშლილი
                                                @endif
                                                </button></td>
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
                                    <div id="map_btn_{{ $record->id }}_s" class="map-style edit-map"></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <li class="d-flex">
                                    <h5 class="mr-3">Id :</h5>
                                    <p>{{ $record->id }}</p>
                                </li>
                                <li class="d-flex">
                                    <h5 class="mr-3">შემსრულებელი :</h5>
                                    <p>{{ $record->user ? $record->user->name : '' }}</p>
                                </li>
                                <li class="m5-2 d-flex">
                                    <h5 class="mr-3">თარიღი :</h5>
                                    <p>{{ $record->date }}</p>
                                </li>
                                <li class="d-flex">
                                    <h5 class="mr-3">შეზღუდვის დრო :</h5>
                                    <p>{{ $record->timer }}წთ</p>
                                </li>
                                <li class="d-flex">
                                    <h5 class="mr-3">პას.პირის სახელი :</h5>
                                    <p>{{ $record->responsible_name }} </p>
                                </li>
                                <li class="d-flex">
                                    <h5 class="mr-3">პას.პირის პოზიცია :</h5>
                                    <p>{{ $record->position }} </p>
                                </li>
                            </div>
                            <div class="col-12 col-md-6">
                                <li class="d-flex">
                                    <h5 class="mr-3">პას.პირის ნომერი :</h5>
                                    <p>{{ $record->number }} </p>
                                </li>
                                <li class="d-flex">
                                    <h5 class="mr-3">რადიუსი :</h5>
                                    <p>{{ $record->radius }} მეტრი</p>
                                </li>
                                <li class="d-flex">
                                    <h5 class="mr-3">სტატუსი :</h5>
                                    <p>@if($record->status == 0)
                                        დაგეგმილი
                                    @elseif ($record->status == 1)
                                        დასრულებული
                                    @else
                                        ჩაშლილი
                                    @endif</p>
                                </li>
                                <li class="d-flex">
                                    <h5 class="mr-3">ჩექინი :</h5>
                                    <p>{{ $record->check_in_time ?? 'არ შემდგარა' }}</p>
                                </li>
                                <li class="d-flex">
                                    <h5 class="mr-3">ჩექაუთი :</h5>
                                    <p>{{ $record->check_out_time ?? 'არ შემდგარა' }}</p>
                                </li>
                            </div>
                            <div class="col-12 detail-line">
                                <li class="d-flex">
                                    <h5 class="mr-3">დავალება :</h5>
                                    <p>{{ $record->task ? $record->task->name : '' }}</p>
                                </li>
                                @if($record->comment)
                                <li class="d-flex">
                                    <h5 class="mr-3">კომენტარი :</h5>
                                    <p>{{ $record->comment }}</p>
                                </li>
                                @endif
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
                                        <option value="{{ $record->assigned_user_id }}">{{ $record->user ? $record->user->name : '' }}
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
                                        <option value="{{ $record->task_id }}">{{ $record->task ? $record->task->name : '' }}</option>
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
                                        <option value="{{ $record->location_id }}">{{ $record->location ? $record->location->name : '' }}</option>
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


    <script src="/assets/js/show-record-map.js"></script>
    <script>
        document.getElementById("excel_export").addEventListener("click", function() {
            var hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = "excel";
            hiddenInput.id = "excel_input";
            hiddenInput.value = "1";
            document.getElementById("record_form").appendChild(hiddenInput);
            document.getElementById("record_form").submit();
            // document.getElementById("record_form").removeChild(hiddenInput);
        });
    
        document.getElementById("filter_button").addEventListener("click", function() {
            var excelInput = document.getElementById("excel_input");
            if (excelInput) {
                excelInput.parentNode.removeChild(excelInput);
            }
        });
    </script>
@stop
