@extends(Auth::user()->role == App\Enum\UserRoleEnum::Admin ? 'layouts.adminLayout' : 'layouts.userLayout')


@section('main_content')
<div class="container">
  <form id="filter" class="container-fluid border-bottom rounded-bottom rounded-5 shadow-lg" style="border-color: gray!important" method="GET" action="/home">
      <div class="col-10">
          <div class="input-group date" id="datepicker1">
            <input autocomplete="off" type="text" class="form-control" id="dfrom" placeholder="Start Date" name="dfrom" value="{{$dfrom}}"/>
            <span class="input-group-append">
              <span class="input-group-text bg-light d-block" placeholder="to">
                <i class="fa fa-calendar"></i>
              </span>
            </span>
          </div>
      </div>
      <div class="col-10">
          <div class="input-group date" id="datepicker2">
            <input autocomplete="off" type="text" class="form-control" id="dto"  placeholder="End Date" name="dto"  value="{{$dto}}"/>
            <span class="input-group-append">
              <span class="input-group-text bg-light d-block">
                <i class="fa fa-calendar"></i>
              </span>
            </span>
          </div>
      </div>
      <div class="col-10">
          <select class="form-control" placeholder="Location" name="location" id="location" onload="changeDefault()">
            <option value="">Show All</option>
              <option>Kuala Lumpur</option>
              <option>Cheras</option>
              <option>Kajang</option>
              <option>Sungai Long</option>
          </select>
          <script>
            var selectedOption = "{{$location}}"; // Get the variable value from the controller
            var selectElement = document.getElementById("location"); // Get the select element
            
            // Loop through the options and set the selected option
            for (var i = 0; i < selectElement.options.length; i++) {
              if (selectElement.options[i].value === selectedOption) {
                selectElement.selectedIndex = i;
                break;
              }
            }
          </script>
      </div>
      <div class="col-10">
          <button class="btn btn-md btn-warning text-white" type="submit">Search</button>
          <button class="btn btn-md btn-danger text-white" id="reset">Reset</button>
          <script>
            var reset = document.getElementById('reset');
            reset.addEventListener('click', function(){
              document.getElementById('dfrom').value = "";
              document.getElementById('dto').value = "";
              document.getElementById('location').value = "";
              document.getElementById('filter').submit();
            });
          </script>
      </div>
  </form>
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


  <div class="flex flex-wrap">
  @foreach ($roomslist as $roomBox)
      <div class="w-19rem bg-white m-2 p-2 max-h-32rem">
        <div class="h-9rem"></div>
        <div class="relative">
          <h1>{{$roomBox->name}}</h1>
          <br>
          <p>Location: {{$roomBox->location}}</p>
          <p>Size: {{$roomBox->capacity}}</p>
          <p>Description: {{$roomBox->description}}</p>
          <h3>RM {{$roomBox->price}}/Day</h3>
          <button class="w-full h-3rem h5"><a class="no-underline" href="/room/{{$roomBox->id}}">More Details</a></button>

        
        </div>
      </div>
  @endforeach
  </div>

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Recipient:</label>
              <input type="text" class="form-control" id="recipient-name">
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Message:</label>
              <textarea class="form-control" id="message-text"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Send message</button>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-md-10">
    <h2 class="p-2 text-white">
        Interested in joining us to rent your office? <br>
        Welcome to apply here!!!
    </h2>
    <form action="/apply">
        <button class="btn btn-md btn-warning text-white" type="submit" action="/apply">Apply</button>
    </form>
  </div>
</div>
@endsection