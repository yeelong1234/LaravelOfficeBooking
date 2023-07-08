@extends(Auth::user()->role == App\Enum\UserRoleEnum::Admin ? 'layouts.adminLayout' : 'layouts.userLayout')
@section('main_content')

<div>
    <table id="mybooking" class="table">
        <thead class="p-2 text-white">
            <tr>
                <th>Room</th>
                <th>Location</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>View</th>
                <th>Edit</th>
                <th>Delete</th>
            <tr>
        </thead>
        <tbody class="p-2 text-white">
            @foreach (Auth::user()->booking as $booking)
            <tr>
                <td>{{$booking->room->name}}</td>
                <td>{{$booking->room->location}}</td>
                <td>{{\Carbon\Carbon::parse($booking->start_date)->format('d/m/Y')}}</td>
                <td>{{\Carbon\Carbon::parse($booking->end_date)->format('d/m/Y')}}</td>
                <td>
                    <a href="{{ route('bookings.view', $booking->id) }}" class="btn btn-primary btn-sm mr-2">View</a>                    
                </td>
                <td>
                    <a href="{{ route('User.edit', $booking->id) }}" class="btn btn-primary btn-sm mr-2">Edit</a>                    
                </td>
                <td>
                    <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection