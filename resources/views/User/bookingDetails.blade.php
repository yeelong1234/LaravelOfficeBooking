@extends(Auth::user()->role == App\Enum\UserRoleEnum::Admin ? 'layouts.adminLayout' : 'layouts.userLayout')

@section('main_content')
<section class="container bg-light">
    
    <div class="row py-3">
        <div class="col-12">
          <h2 class="text-900 border-bottom-2 pb-2 mb-5">Booking Details</h2>
          @can('isAdmin')
              <h3>User: {{$booking->user}}</h3>
          @endcan
          <h3>Room: {{$booking->room}} </h3>
          <h3>Start Date: {{substr($booking->start_date,0,10)}}</h3>
          <h3>End Date: {{substr($booking->end_date,0,10)}}</h3>
          <h3>Booking Date: {{substr($booking->booking_date,0,10)}}</h3>
          <h3>Total Price: RM {{$booking->total_price}}</h3>
          @can('isAdmin')
          <form id="statusForm" action="/bookings/{{$booking->id}}/updateStatus" method="post">
            @csrf
            <label for="status" class="text-900 h3 pr-2">Booking Status:</label>
            <select name="status" id="status">
                @foreach (App\Enum\BookingStatusEnum::cases() as $item)
                    <option value="{{$item}}">{{$item}}</option>
                @endforeach
            </select>
            <script>
                var selectedOption = "{{$booking->booking_status}}"; // Get the variable value from the controller
                var selectElement = document.getElementById("status"); // Get the select element
                
                // Loop through the options and set the selected option
                for (var i = 0; i < selectElement.options.length; i++) {
                  if (selectElement.options[i].value == selectedOption) {
                    selectElement.selectedIndex = i;
                    break;
                  }
                }

                selectElement.addEventListener('change', function(){
                    document.getElementById('statusForm').submit();
                });
              </script>
          </form>
          @endcan
        </div>        
      </div>
</section>
@endsection