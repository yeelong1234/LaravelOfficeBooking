<?php

namespace App\Http\Controllers;

use App\Enum\BookingStatusEnum;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function __construct(){
        $this->middleware('can:isAdmin');
    }
    public function adminHome() {
        
        if(Gate::allows('isAdmin')){
            $today = Carbon::now();
            $roomsList = Room::where('approve', false)->select(['id', 'name', 'location', 'price', 'capacity', 'description'])->get();
            $latestBookings = Booking::distinct()->join('users', 'bookings.user_id', 'users.id')->join('rooms', 'bookings.room_id', 'rooms.id')->select(['bookings.id', 'users.name AS name', 'rooms.name AS room', 'bookings.start_date', 'bookings.end_date', 'bookings.booking_date'])->orderBy('booking_date', 'desc')->get();
            $todayBooking = Booking::whereNot(
                function ($query) use ($today) {
                    $query->where('start_date', '>=' ,$today)->where('end_date', '>=' ,$today);
                }
                )->count();
            $availableSeats = Room::distinct()->leftjoin('bookings', 'bookings.room_id', '=', 'rooms.id')->whereNull('bookings.start_date')->where('approve', true)
            ->orwhere(
                function ($query) use ($today) {
                    $query->where('bookings.start_date', '>' ,$today)->where('bookings.end_date', '>=' ,$today);
                }
                )->sum('capacity');
            $totalSales = Booking::where('booking_status', BookingStatusEnum::Completed)->sum('total_price');
            $countRoomList = $roomsList->count();
            return view('Admin/admin', [
                'roomsDetails' => $roomsList,
                'latestBookings' => $latestBookings,
                'countRoomList' => $countRoomList,
                'todayBooking' => $todayBooking,
                'totalSales' => $totalSales,
            'availableSeats' => $availableSeats]);
        }
    }
    
    public function adminRoomList() {
        $roomsList = Room::where('approve', false)->get();
        $today = Carbon::now();
        $availableRoomList = Room::distinct()->leftjoin('bookings', 'bookings.room_id', '=', 'rooms.id')->whereNull('bookings.start_date')->where('approve', true)
        ->orwhere(
            function ($query) use ($today) {
                $query->where('bookings.start_date', '>' ,$today)->where('bookings.end_date', '>=' ,$today);
            }
            )
        ->select('rooms.id AS id', 'rooms.name AS name', 'rooms.location AS location', 'rooms.price AS price', 'rooms.capacity AS capacity', 'rooms.description AS description')
        ->get();
        $unavailableRoomList = Room::distinct()->leftjoin('bookings', 'bookings.room_id', '=', 'rooms.id')->where('approve', true)
        ->whereNot(
            function ($query) use ($today) {
                $query->where('bookings.start_date', '>' ,$today)->where('bookings.end_date', '>=' ,$today);
            }
            )
        ->select('rooms.id AS id', 'rooms.name AS name', 'rooms.location AS location', 'rooms.price AS price', 'rooms.capacity AS capacity', 'rooms.description AS description')
        ->get();
        return view('Admin/adminRoomList', [
            'roomsDetails' => $roomsList,
            'availableRoomsDetails' => $availableRoomList,
            'unavailableRoomsDetails' => $unavailableRoomList
        ]);
    }

    public function adminCreateBooking() {
        $userName = User::where('role', 'user')->get(['id', 'name', 'email']);
        $roomList = Room::where('approve', true)->get();
        return view('Admin/adminAddBooking', ['userName' => $userName, 'roomList' => $roomList]);
    }

    public function bookingList() {
        $bookingList = [];
        foreach (BookingStatusEnum::cases() as $value) {
            array_push($bookingList, Booking::distinct()->join('users', 'bookings.user_id', 'users.id')->join('rooms', 'bookings.room_id', 'rooms.id')->select(['bookings.id', 'users.name AS name', 'rooms.name AS room', 'bookings.start_date', 'bookings.end_date', 'bookings.booking_date'])->where("booking_status", $value)->get());
        }
        return view('admin/adminBookingList', [
            'bookingList' => $bookingList
        ]);
    }
}
