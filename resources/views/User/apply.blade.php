@extends(Auth::user()->role == App\Enum\UserRoleEnum::Admin ? 'layouts.adminLayout' : 'layouts.userLayout')


@section('main_content')
<div class="container">
<div>
    <h4 class="text-white">Please fill your information into the form below to apply:</h2>
</div>

<form action="/addRoom" class="row" method="post" enctype="multipart/form-data">
    @csrf
    <div class="col-10">
        <input name="name" class="form-control" type="text" placeholder="Name">
    </div>
    
    <div class="col-10">
        <select class="form-control" name="location">
            <option>Kuala Lumpur</option>
            <option>Cheras</option>
            <option>Kajang</option>
            <option>Sungai Long</option>
        </select>
    </div>
    <div class="col-10">
        <input class="form-control" name="description" type="textarea" placeholder="Description">
    </div>
    <div class="col-10">
        <input name="price" class="form-control" type="number" placeholder="Price">
    </div>
    <div class="col-10">
        <input name="capacity" class="form-control" type="number" placeholder="Capacity">
    </div>
    <div class="col-10">
        <div class="form-control">
            <label class="text-900" >Image of the office: </label>
            <input type="file" name="image"><br>
        </div>
    </div>
    @if($errors->any())
        @foreach ($errors->all() as $error)
            <li class="text-white">{{ $error }}</li>
        @endforeach
    @endif
    <div class="col-10">
        <button class="btn btn-md btn-warning text-white" type="submit">Submit</button>
    </div>
</form>

</div>
@endsection