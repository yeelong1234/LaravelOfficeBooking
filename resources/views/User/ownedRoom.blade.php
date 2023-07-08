@extends(Auth::user()->role == App\Enum\UserRoleEnum::Admin ? 'layouts.adminLayout' : 'layouts.userLayout')

@section('main_content')
    <div>
        <table class="table">
            <thead class="p-2 text-white">
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Description</th>
                    <th>Capacity</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="p-2 text-white">
                @foreach ($roomsList as $room)
                    <tr>
                        <td>{{$room->name}}</td>
                        <td>{{$room->location}}</td>
                        <td>{{$room->description}}</td>
                        <td>{{$room->capacity}}</td>
                        <td>{{$room->price}}</td>
                        <td>
                            
                                <a href="/editRoom/{{$room->id}}" class="btn btn-primary btn-sm mr-2">Edit</a>
                                <a href="/deleteRoom/{{$room->id}}" class="btn btn-danger btn-sm">Delete</a>
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection