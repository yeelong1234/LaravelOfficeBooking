@extends(Auth::user()->role == App\Enum\UserRoleEnum::Admin ? 'layouts.adminLayout' : 'layouts.userLayout')

@section('main_content')
    <div class="container">
        <form action="/editRoom" class="row" method="post">
            @csrf
            <input type="hidden" name="id" value = {{$room->id}}>
            <div class="col-10">
                <input name="name" class="form-control" type="text" placeholder="Name" value="{{$room->name}}">
            </div>
            
            <div class="col-10">
                <select class="form-control" name="location" value="{{$room->location}}">
                    <option>Kuala Lumpur</option>
                    <option>Cheras</option>
                    <option>Kajang</option>
                    <option>Sungai Long</option>
                </select>
            </div>
            <div class="col-10">
                <input class="form-control" name="description" type="textarea" placeholder="Description" value="{{$room->description}}">
            </div>
            <div class="col-10">
                <input name="price" class="form-control" type="number" placeholder="Price" value="{{$room->price}}">
            </div>
            <div class="col-10">
                <input name="capacity" class="form-control" type="number" placeholder="Capacity" value="{{$room->capacity}}">
            </div>
            <div class="col-10">
                <div class="form-control">
                    <label>Image of the office: </label>
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