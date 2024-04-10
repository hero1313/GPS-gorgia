@extends('website.index')
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            @include('website.layouts.navbar')
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
                                                <th>სახელი</th>
                                                <th>ელფოსტა</th>
                                                <th>ნომერი</th>
                                                <th>დეპარტამენტი</th>
                                                <th>როლი</th>
                                                <th>რედაქტირება</th>
                                                <th>წაშლა</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->number }}</td>
                                                    <td><button
                                                            class="btn btn-success">{{ $user->department_index == 1 ? 'დისტრიბუცია' : ($user->department_index == 2 ? 'კორპორატიული გაყიდვები' : '') }}</button>
                                                    </td>
                                                    <td><button class="btn btn-success">{{ $user->role == 1 ? 'ადმინი' : ($user->role == 2 ? 'პრისელერი' : '') }}</button></td>
                                                    <td><button class="btn btn-primary" data-toggle="modal"
                                                            data-target="#edit_user_{{ $user->id }}">რედაქტირება</button>
                                                    </td>
                                                    <td><button class="btn btn-danger" data-toggle="modal"
                                                            data-target="#delete_user_{{ $user->id }}">წაშლა</button>
                                                    </td>
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
        @foreach ($users as $user)
            {{-- edit user --}}
            <div class="modal fade" id="edit_user_{{ $user->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <form action="{{ route('users.update', $user->id ) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">იუზერის როლის რედაქტირება</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="container">
                            <div class="form-group">
                                <label for="inputState">როლი</label>
                                <select id="inputState" name="role" class="form-control">
                                    <option value="{{ $user->role }}">{{ $user->role == 1 ? 'ადმინი' : ($user->role == 2 ? 'პრისელერი' : '') }}</option>
                                    <option value="1">ადმინი</option>
                                    <option value="2">პრისელერი</option>
                                </select>
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

            {{-- delete user --}}
            <div class="modal fade" id="delete_user_{{ $user->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <form action="{{ route('users.destroy',  $user->id ) }}" method="post">
                        @method('delete')
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">იუზერის წაშლა</h5>
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

    @stop
