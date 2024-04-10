@extends('website.index')
@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

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
                <button class="btn btn-primary add-btn" data-toggle="modal" data-target="#add_location">დამატება</button>
            </div>
        </div>

        <div class="mb-3 container-fluid">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="mb-4 shadow card">
                        <div class="py-3 card-header">
                            <h6 class="m-0 font-weight-bold text-primary">ლოკაციები</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>დასახელება</th>
                                            <th>მდებარეობა</th>
                                            <th>რედაქტირება</th>
                                            <th>დეტალები</th>
                                            <th>წაშლა</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($locations as $location)
                                            <tr>
                                                <td>{{ $location->name }}</td>
                                                <td>{{ $location->city }}</td>
                                                <td><button class="btn btn-primary" data-toggle="modal"
                                                        data-target="#edit_location_{{ $location->id }}">რედაქტირება</button>
                                                </td>
                                                <td><button class="btn btn-success" data-toggle="modal"
                                                        data-target="#detail_location_{{ $location->id }}">დეტალები</button>
                                                </td>
                                                <td><button class="btn btn-danger" data-toggle="modal"
                                                        data-target="#delete_location_{{ $location->id }}">წაშლა</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <iframe class="object-map"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d760585.5823097462!2d43.422188818936846!3d41.87054111918487!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40447338bc444149%3A0x9802b05c2185f082!2sGorgia!5e0!3m2!1sen!2sge!4v1711442804792!5m2!1sen!2sge"
                        width="100%" height="700px" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>

    @foreach ($locations as $location)
        {{-- edit location --}}
        <div class="modal fade" id="edit_location_{{ $location->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form action="{{ route('locations.update', $location->id ) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ობიექტის რედაქტირება</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                        <div class="modal-body row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">დასახელება</label>
                                    <input type="text" required class="form-control" value="{{ $location->name }}" name="name">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="inputState">ქალაქი</label>
                                    <select id="inputState" name="city" value="{{ $location->city }}"
                                        class="form-control">
                                        <option value="თბილისი">თბილისი</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">ლატ</label>
                                    <input type="text" name="lat" value="{{ $location->lat }}" class="form-control"
                                        value="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">ლნგ</label>
                                    <input type="text" name="lng" value="{{ $location->lng }}" class="form-control"
                                        value="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">პასუხისმგებელი პირი</label>
                                    <input type="text" name="owner" value="{{ $location->owner }}" class="form-control"
                                        value="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">პასუხისმგებელი პირის ნნომერი</label>
                                    <input type="number" name="owner_number" value="{{ $location->owner_number }}"
                                        class="form-control" value="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">რადიუსის შეზღუდვა (მეტრებში)</label>
                                    <input type="number" name="radius" value="{{ $location->radius }}"
                                        class="form-control" value="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">დროის შეზღუდვა (წუთებში)</label>
                                    <input type="number" name="timer" value="{{ $location->timer }}"
                                        class="form-control" value="">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">აღწერა</label>
                                    <textarea   name="description" class="form-control">{{ $location->description }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">მდებარეობა</label>
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25743.807174985322!2d44.7802700476656!3d41.68938444433022!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40440cc00a79a799%3A0x8accaace2cb10853!2sMtatsminda%20Park!5e0!3m2!1sen!2sge!4v1712054182759!5m2!1sen!2sge"
                                        width="100%" height="300" style="border:0;" allowfullscreen=""
                                        loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary">მდებარეობის დამახსოვრება</button>
                            <button type="submit" class="btn btn-primary">დადასტურება</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">დახურვა</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- location detail --}}
        <div class="modal fade" id="detail_location_{{ $location->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">ობიექტის დეტალები</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body row">
                      <div class="col-12 col-md-6">
                          <li class="d-flex">
                              <h5 class="mr-3">დასახელება :</h5>
                              <p>{{ $location->name }}</p>
                          </li>
                          <li class="d-flex">
                              <h5 class="mr-3">ქალაქი :</h5>
                              <p>{{ $location->city }}</p>
                          </li>
                          <li class="d-flex">
                              <h5 class="mr-3">გრძედი :</h5>
                              <p>{{ $location->lat }}</p>
                          </li>
                          <li class="d-flex">
                              <h5 class="mr-3">დროის შეზღუდვა :</h5>
                              <p>{{ $location->timer }}</p>
                          </li>

                      </div>
                      <div class="col-12 col-md-6">
                          <li class="d-flex">
                              <h5 class="mr-3">საკონტაქტო პირი :</h5>
                              <p>{{ $location->owner }}</p>
                          </li>
                          <li class="d-flex">
                              <h5 class="mr-3">საკონტაქტო ნომერი :</h5>
                              <p>{{ $location->owner_number }}</p>
                          </li>
                          <li class="d-flex">
                              <h5 class="mr-3">განედი :</h5>
                              <p>{{ $location->lng }}</p>
                          </li>
                          <li class="d-flex">
                              <h5 class="mr-3">რადიუსი :</h5>
                              <p>{{ $location->radius }}</p>
                          </li>
                      </div>
                      <div class="col-12 detail-line">
                          <li class="d-flex">
                              <h5 class="mr-3">აღწერა :</h5>
                              <p>{{ $location->description }}</p>
                          </li>
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">დახურვა</button>
                  </div>
              </div>
            </div>
        </div>

        {{-- delete location --}}
        <div class="modal fade" id="delete_location_1" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <form action="{{ route('locations.destroy', $location->id ) }}" method="post">
                @method('delete')
                @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">ობიექტის წაშლა</h5>
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


    {{-- add location --}}
    <div class="modal fade" id="add_location" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('locations.store') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ობიექტის დამატება</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">დასახელება</label>
                                <input type="text" required class="form-control" name="name">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="inputState">ქალაქი</label>
                                <select id="inputState" name="city" class="form-control">
                                    <option value="თბილისი">თბილისი</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">გრძედი</label>
                                <input type="text" name="lat" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">განედი</label>
                                <input type="text" name="lng" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">პასუხისმგებელი პირი</label>
                                <input type="text" name="owner" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">პასუხისმგებელი პირის ნნომერი</label>
                                <input type="number" name="owner_number" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">რადიუსის შეზღუდვა (მეტრებში)</label>
                                <input type="number" name="radius" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">დროის შეზღუდვა (წუთებში)</label>
                                <input type="number" name="timer" class="form-control" value="">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">აღწერა</label>
                                <textarea   name="description" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">მდებარეობა</label>
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25743.807174985322!2d44.7802700476656!3d41.68938444433022!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40440cc00a79a799%3A0x8accaace2cb10853!2sMtatsminda%20Park!5e0!3m2!1sen!2sge!4v1712054182759!5m2!1sen!2sge"
                                    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">მდებარეობის დამახსოვრება</button>
                        <button type="submit" class="btn btn-primary">დადასტურება</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">დახურვა</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
@stop
