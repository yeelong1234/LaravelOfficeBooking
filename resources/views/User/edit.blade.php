@extends(Auth::user()->role == App\Enum\UserRoleEnum::Admin ? 'layouts.adminLayout' : 'layouts.userLayout')
@section('main_content')
    <div class="container">
        <h1 class="text-white">Edit Booking</h1>

        <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <div class="input-group date" id="datepicker1">
                    <input autocomplete="off" type="text" class="form-control" id="date" placeholder="From" name="start_date" id="start_date" value="{{substr($booking['start_date'], 0, 10)}}"/>
                    <span class="input-group-append">
                    <span class="input-group-text bg-light d-block" placeholder="to">
                        <i class="fa fa-calendar"></i>
                    </span>
                    </span>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="input-group date" id="datepicker2">
                    <input autocomplete="off" type="text" class="form-control" id="date"  placeholder="To" name="end_date" id="end_date"  value="{{substr($booking['end_date'], 0, 10)}}"/>
                    <span class="input-group-append">
                    <span class="input-group-text bg-light d-block">
                        <i class="fa fa-calendar"></i>
                    </span>
                    </span>
                </div>
            </div>
            <br>
            @if ($errors->any())
                <div class="row py-3">
                    <div class="col-12">
                        <div class="alert alert-danger pt-3 pb-1  mt-3 mp-2">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
@endsection