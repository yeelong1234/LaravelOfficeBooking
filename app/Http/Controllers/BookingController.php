<?php

namespace App\Http\Controllers;

use App\Enum\BookingStatusEnum;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    
    public function bookingConfirmation(Request $request) {
        $rules = [
            'room_id' => 'required|Numeric',
            'start_date' => 'required|min:2|max:100',
            'end_date' => 'required|min:2|max:100',
        ];

        $validate =  Validator::make($request->all(), $rules, []);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->messages())->withInput($request->all());
        }


        if ($request->has(['start_date', 'end_date'])) {
            $sdfrom = $request->input('start_date');
            $sdto = $request->input('end_date');

            // Check if the room is already booked for the selected dates
            $isRoomBooked = Booking::where('room_id', $request->get('room_id'))
            ->where(function ($query) use ($sdfrom, $sdto) {
            $query
                ->whereBetween('start_date', [$sdfrom, $sdto])
                ->orWhereBetween('end_date', [$sdfrom, $sdto])
                ->orWhere(function ($query) use ($sdfrom, $sdto) {
                    $query
                        ->where('start_date', '<', $sdfrom)
                        ->where('end_date', '>', $sdto);
                });
        })
        ->exists();

        if ($isRoomBooked) {
            $error = \Illuminate\Validation\ValidationException::withMessages(['not available' => ['This room has been booked for the dates you have selected'],]);
            throw $error;
        } elseif ($sdfrom >= $sdto) {
            $error = \Illuminate\Validation\ValidationException::withMessages(['date error' => ['Date TO is less than or equal to date FROM'],]);
            throw $error;
        }   
        } else {
            $error = \Illuminate\Validation\ValidationException::withMessages(['dates' => ['Dates From or To not set'],]);
            throw $error;
        }

        $countDays = Carbon::parse($sdfrom)->diffInDays(Carbon::parse($sdto));
        $roomPrice = Room::where('id', $request->input('room_id'))->sum('price');
        $totalRoomPrice = $countDays * $roomPrice;
        $bookingConfirmation = new Booking();

        $bookingConfirmation->room_id = $request->input('room_id');
        $bookingConfirmation->user_id = $request->exists(['user_id']) ? $request->input('user_id') : auth()->user()->id;
        $bookingConfirmation->booking_status = BookingStatusEnum::Created;
        $bookingConfirmation->start_date = $sdfrom;
        $bookingConfirmation->end_date = $sdto;
        $bookingConfirmation->booking_date = Carbon::now()->format('y-m-d H:i:s');
        $bookingConfirmation->total_price = $totalRoomPrice;

        $bookingConfirmation->save();
        
        return view('User/bookingConfirmation', ['bookingConfirmation' => $bookingConfirmation, 'countDays' => $countDays, 'totalRoomPrice' => $totalRoomPrice]);
    }

    public function myBooking(){
        $bookings = Booking::all();
        return view('User.myBooking', compact('bookings'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        return view('User.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        $booking = Booking::findOrFail($booking->id);
        return view('User.edit', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $booking = Booking::findOrFail($booking->id);
        $rules = [
            'start_date' => 'required|min:2|max:100',
            'end_date' => 'required|min:2|max:100',
        ];

        $validate =  Validator::make($request->all(), $rules, []);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->messages())->withInput($request->all());
        }
        

        if ($request->has(['start_date', 'end_date'])) {

            $sdfrom = $request->input('start_date');

            $sdto = $request->input('end_date');

            // Check if the room is already booked for the selected dates
            $isRoomBooked = Booking::where('room_id', $booking->room_id)
            ->where(function ($query) use ($sdfrom, $sdto, $booking) {
            $query
                ->whereBetween('start_date', [$sdfrom, $sdto])
                ->orWhereBetween('end_date', [$sdfrom, $sdto])
                ->orWhere(function ($query) use ($sdfrom, $sdto) {
                    $query
                        ->where('start_date', '<', $sdfrom)
                        ->where('end_date', '>', $sdto);
                });
        })
        ->exists();

        if ($isRoomBooked) {
            $error = \Illuminate\Validation\ValidationException::withMessages(['not available' => ['This room has been booked for the dates you have selected'],]);
            throw $error;
        } elseif ($sdfrom >= $sdto) {
            $error = \Illuminate\Validation\ValidationException::withMessages(['date error' => ['Date TO is less than or equal to date FROM'],]);
            throw $error;
        }   
        } else {
            $error = \Illuminate\Validation\ValidationException::withMessages(['dates' => ['Dates From or To not set'],]);
            throw $error;
        }

        $countDays = Carbon::parse($sdfrom)->diffInDays(Carbon::parse($sdto));
        $roomPrice = Room::where('id', $booking->room_id)->sum('price');
        $totalRoomPrice = $countDays * $roomPrice;
        
        $booking->start_date = $sdfrom;
        $booking->end_date = $sdto;
        $booking->total_price = $totalRoomPrice;
        $booking->save();

        return redirect()->to('/mybooking')->with('success', 'Booking updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking = Booking::findOrFail($booking->id);
        $booking->delete();

        return redirect()->to('/mybooking')->with('success', 'Booking deleted successfully');
    }

    public function viewDetails(Booking $booking) {
        $booking = Booking::where('bookings.id', $booking->id)->join('rooms', 'bookings.room_id', 'rooms.id')->join('users', 'bookings.user_id', 'users.id')->
                    select(['rooms.name AS room', 'users.name AS user', 'bookings.start_date', 'bookings.end_date', 'bookings.booking_date', 'bookings.total_price','bookings.booking_status', 'bookings.id AS id']) 
                    ->first();
        return view('User/bookingDetails', [
            'booking' => $booking
        ]);
    }

    public function updateStatus(Request $request, Booking $booking) {
        $update = Booking::findorFail($booking->id);
        $update->booking_status = $request->status;
        $update->save(); 

        return redirect()->back();
    }
}
