@extends(Auth::user()->role == App\Enum\UserRoleEnum::Admin ? 'layouts.adminLayout' : 'layouts.userLayout')

@section('title') Thank you for booking @endsection

@section('main_content')

<section class="container bg-light">
    <div class="row py-3">
        <div class="col-12">
          <h2 class="featurette-heading text-success">Thank you for booking</span></h2>
          <hr />
          <h2>Booking Details</h2>
          <h3>Start Date: {{$bookingConfirmation->start_date}}</h3>
          <h3>End Date: {{$bookingConfirmation->end_date}}</h3>
          <h3>Total Days: {{$countDays}}</h3>
          <h3>Total Price: RM{{$totalRoomPrice}}</h3>
          <p>The room has been booked, expect confirmation soon!</p>
          <button><a href="/home" class="no-underline text-black hover:background-grey-300">Back To Home</a></button>
        </div>        
      </div>
</section>
@endsection