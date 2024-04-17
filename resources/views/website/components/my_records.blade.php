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
                                                <th>დავალება</th>
                                                <th>ლოკაცია</th>
                                                <th>დეტალები</th>
                                                <th>ჩექინი & ჩექაუთი</th>
                                                <th>კომენტარი</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($records as $record)
                                                <tr>
                                                    <td>{{ $record->task->name }}</td>
                                                    <td>{{ $record->location->name }}</td>
                                                    <td><button class="btn btn-primary edit_maps" data-toggle="modal"
                                                        data-target="#record_detail_{{ $record->id }}" id="map_btn_{{ $record->id }}"  data-lat="{{ $record->location->lat }}" data-lng="{{ $record->location->lng }}">დეტალები</button>
                                                    </td>
                                                    <td>
                                                        @if(!$record->check_in_time && $check == 0)
                                                            <button data-lat="{{ $record->location->lat }}" data-lng="{{ $record->location->lng }}" data-radius="{{ $record->radius }}" class="btn btn-success check-in" data-toggle="modal"
                                                            data-target="#record_checkin_{{ $record->id }}">ჩექინი</button>
                                                        @endif
                                                        @if($record->check_in_time && !$record->check_out_time)
                                                        <button data-lat="{{ $record->location->lat }}" data-lng="{{ $record->location->lng }}" data-radius="{{ $record->radius }}"  
                                                            data-time="{{ Carbon\Carbon::parse($record->check_in_time)->addMinutes($record->timer)->format('Y-m-d H:i:s') }}"  
                                                            class="btn btn-danger check-out" data-toggle="modal"
                                                            data-target="#record_checkout_{{ $record->id }}">ჩექაუთი</button>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary" data-toggle="modal"
                                                            data-target="#record_comment_{{ $record->id }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="26"
                                                                height="26" fill="currentColor" class="bi bi-chat-dots"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                                                                <path
                                                                    d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2" />
                                                            </svg>
                                                        </button>
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
        <button class="btn btn-primary " id="custom_btn" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                <path
                    d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
            </svg>
        </button>
        <div id="map_custom" class="map-style edit-map"></div>
        <input type="text" id="curent_lat">
        <input type="text" id="curent_lng">

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
                                    <div id="map_btn_{{ $record->id }}_s" class="map-style edit-map"></div>
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

            {{-- comment modal --}}
            <div class="modal fade" id="record_comment_{{ $record->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <form action="{{ route('comment.records.update', $record->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">კომენტარის დამატება</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">კომენტარი</label>
                                    <textarea class="form-control" name="comment" id="exampleFormControlTextarea1" rows="3">{{ $record->comment }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">დახურვა</button>
                                <button type="submit" class="btn btn-primary">შენახვა</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- checkin modal --}}
            <div class="modal fade" id="record_checkin_{{ $record->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <form action="{{ route('checkin.records.update', $record->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">ჩექინი</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="image" required class="custom-file-input">
                                        <label class="custom-file-label" for="inputGroupFile04">სურათის ატვირთვა</label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">დახურვა</button>
                                <button type="submit" class="btn btn-primary">ჩექინი</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- checkout modal --}}
            <div class="modal fade" id="record_checkout_{{ $record->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <form action="{{ route('checkout.records.update', $record->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">ჩექაუთი</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="inputState">სტატუსი</label>
                                    <select id="inputState" name="status" class="form-control">
                                        <option value="1">დასრულებული</option>
                                        <option value="2">ჩაშლილი</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">კომენტარი</label>
                                    <textarea class="form-control" name="comment" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">დახურვა</button>
                                <button type="submit" class="btn btn-primary">ჩექაუთი</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
        <script src="/assets/js/show-record-map.js"></script>


        <script>
            $(document).ready(function(){
                function calculateDistance(lat1, lon1, lat2, lon2) {
                    var radius = 6371000; // Earth radius in meters
            
                    var lat1Rad = lat1 * Math.PI / 180;
                    var lon1Rad = lon1 * Math.PI / 180;
                    var lat2Rad = lat2 * Math.PI / 180;
                    var lon2Rad = lon2 * Math.PI / 180;
            
                    var deltaLat = lat2Rad - lat1Rad;
                    var deltaLon = lon2Rad - lon1Rad;
            
                    var a = Math.sin(deltaLat / 2) * Math.sin(deltaLat / 2) +
                            Math.cos(lat1Rad) * Math.cos(lat2Rad) *
                            Math.sin(deltaLon / 2) * Math.sin(deltaLon / 2);
                    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            
                    var distance = radius * c;
            
                    return distance;
                }
            
                var userLat = 41.74850286845791; // Latitude of the user's location
                var userLon = 44.776175022125244; // Longitude of the user's location
            
                
                $('.check-in').each(function() {
                    // $('#custom_btn').click()
                    var locationLat = parseFloat($(this).data('lat'));
                    var locationLon = parseFloat($(this).data('lng'));
                    var radius = parseFloat($(this).data('radius'));
            
                    var distance = calculateDistance(userLat, userLon, locationLat, locationLon);
                    if (distance <= radius) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
                $('.check-out').each(function() {
                    var locationLat = parseFloat($(this).data('lat'));
                    var locationLon = parseFloat($(this).data('lng'));
                    var radius = parseFloat($(this).data('radius'));
            
                    var distance = calculateDistance(userLat, userLon, locationLat, locationLon);
            
                    if (distance <= radius) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });


                // ესენი დასასრულებელია არ მუშაობს ინფუთებიდან გვიან მოდის ველიუ
                $('.check-in').click(function() {
                    $('#custom_btn').click()
                    var locationLat = $(this).data('lat');
                    var locationLon = $(this).data('lng');
                    var radius = parseFloat($(this).data('radius'));
                    userLat = $('#curent_lat').val()
                    userLon = $('#curent_lng').val()

                    
                    alert($('#curent_lat').val())

                    var distance = calculateDistance(userLat, userLon, locationLat, locationLon);
                    console.log(userLat, userLon, locationLat, locationLon)
                    if (distance > radius) {
                            Swal.fire({
                            title: 'ჩექინი ვერ შედგა',
                            text: 'ჩექინი განხორციელება შეგეძლებათ ობიექტის ტერიტორიაზე',
                            icon: 'error',
                            confirmButtonText: 'დახურვა'
                            })
                            $(this).removeAttr('data-toggle');  
                    }

                })

                $('.check-out').click(function() {
                    $('#custom_btn').click()
                    var locationLat = parseFloat($(this).data('lat'));
                    var locationLon = parseFloat($(this).data('lng'));
                    var radius = parseFloat($(this).data('radius'));
                    var userLat = 41.7497088
                    var userLon = 44.7840256


                    var distance = calculateDistance(userLat, userLon, locationLat, locationLon);
                    if (distance > radius) {
                            Swal.fire({
                            title: 'ჩექაუთი ვერ შედგა',
                            text: 'ჩექაუთი განხორციელება შეგეძლებათ ობიექტის ტერიტორიაზე',
                            icon: 'error',
                            confirmButtonText: 'დახურვა'
                            })
                            $(this).removeAttr('data-toggle');  
                    }
                })
            });
                

            
            </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var checkoutButtons = document.querySelectorAll('.check-out');
            checkoutButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    var currentTime = new Date();
                    var checkoutTime = new Date(this.dataset.time);
                    var hours = checkoutTime.getHours();
                    var minutes = checkoutTime.getMinutes();
                    var seconds = checkoutTime.getSeconds();

                    var formattedTime = hours + ':' + minutes + ':' + seconds;
                    if (checkoutTime > currentTime) {
                        Swal.fire({
                        title: 'ჩექაუთი ვერ შედგა',
                        text: 'ჩექაუთი განხორციელება შეგეძლებათ ' + formattedTime + ' დროის შემდეგ',
                        icon: 'error',
                        confirmButtonText: 'დახურვა'
                        })
                        $(this).removeAttr('data-toggle');
                    }
                    else{
                        $(this).attr('data-toggle', 'modal');
                    }
                });
            });
        });
        
    </script>

    @stop
