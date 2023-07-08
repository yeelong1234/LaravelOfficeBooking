<?php

namespace App\Http\Controllers;

use App\Enum\UserRoleEnum;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use App\Models\RoomImages;
use App\Http\Controllers\RoomImagesController;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class RoomController extends Controller
{
    public function index(Request $request) {
        $roomList = empty($request->input('dto')) && empty($request->input('dfrom')) && empty($request->input('location')) ? RoomResource::collection(Room::where('approve', true)->get()) : $this->search($request);
        return Auth::user()->role == UserRoleEnum::Admin ? redirect('/admin') : view('User/home', [
            'roomslist' =>  $roomList,
            'location' => $request->location,
            'dfrom' => $request->dfrom,
            'dto' => $request->dto,
        ]);
    }

    public function show() {
        
        $roomsList = Auth::user()->role == UserRoleEnum::Admin ? RoomResource::collection(Room::where('approve', true)->get()) : RoomResource::collection(Room::where('approve', true)->Where('user_id', Auth::user()->id)->get());
        return view('User/ownedRoom', [
            'roomsList' =>  $roomsList,
        ]);
    }

   

    public function search(Request $request) {

        $sdfrom =  $request->get('dfrom');
        $sdto =  $request->get('dto');
        $location = $request->string('location');
        $sroom = [];
        if (!empty($request->input('dfrom')) && !empty($request->input('dto'))) {
            
            $sroom = Room::distinct()->leftjoin('bookings', 'bookings.room_id', '=', 'rooms.id')
            ->whereNull('bookings.start_date')->where('approve', true)
            ->orwhere(
                    function ($query) use ($sdfrom, $sdto) {
                        $query->where('bookings.start_date', '>' ,$sdfrom)->whereNot('bookings.end_date', '<=' ,$sdfrom)
                        ->where('bookings.start_date', '<' ,$sdto)->whereNot('bookings.end_date', '>=' ,$sdto);
                    }
                )
                ->when($location, function (Builder $query, string $location){
                    if(!empty($location)) {
                        $query->where('rooms.location', $location);
                    }
                })
            ->select('rooms.id AS id', 'rooms.name AS name', 'rooms.location AS location', 'rooms.price AS price', 'rooms.capacity AS capacity', 'rooms.description AS description')
            ->get();

        } elseif (!empty($request->input('dfrom')) && empty($request->input('dto'))) {
            
            $sroom = Room::distinct()->leftjoin('bookings', 'bookings.room_id', '=', 'rooms.id')->whereNull('bookings.start_date')->where('approve', true)
            ->orwhere(
                function ($query) use ($sdfrom) {
                    $query->where('bookings.start_date', '>' ,$sdfrom)->whereNot('bookings.end_date', '<=' ,$sdfrom);
                }
                )
            ->when($location, function (Builder $query, string $location){
                if(!empty($location)) {
                    $query->where('rooms.location', $location);
                }
            })
            ->select('rooms.id AS id', 'rooms.name AS name', 'rooms.location AS location', 'rooms.price AS price', 'rooms.capacity AS capacity', 'rooms.description AS description')
            ->get();

        } elseif (empty($request->input('dfrom')) && !empty($request->input('dto'))) {

            $sroom = Room::distinct()->leftjoin('bookings', 'bookings.room_id', '=', 'rooms.id')->whereNull('bookings.start_date')->where('approve', true)
                ->orwhere(
                    function ($query) use ($sdto) {
                        $query->where('bookings.start_date', '<' ,$sdto)->whereNot('bookings.end_date', '>=' ,$sdto);
                    }
                )
            ->when($location, function (Builder $query, string $location){
                if(!empty($location)) {
                    $query->where('rooms.location', $location);
                }
            })
            ->select('rooms.id AS id', 'rooms.name AS name', 'rooms.location AS location', 'rooms.price AS price', 'rooms.capacity AS capacity', 'rooms.description AS description')
            ->get();

        } else {
            $sroom = Room::distinct()->where('approve', true)
            ->when($location, function (Builder $query, string $location){
                $query->where('location', $location);
            })
            ->get();

        }

        

        return $sroom;
    }

    public function oneroom($id, Request $request) {

        if ($request->input('name') != null)
            $name = $request->input('name');
        else $name = '';

        return view('User/oneroom', [
            'room' =>  Room::with('images')->where('id', $id)->get(),
            'name' => $name
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user()->role;
        return view('User/apply', ['user'=>$user]);//
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'location' => 'required',
            'description' => 'required',
            'price' => 'integer | required',
            'capacity' => 'integer | required',

        ]);

        $approve = Auth::user()->role == UserRoleEnum::Admin ? true : false;

        
       Room::create([
            'name' => $request->name,
            'location' => $request->location,
            'description' => $request->description,
            'price' => $request->price,
            'capacity' => $request->capacity,
            'user_id' => Auth::id(),
            'approve' => $approve
       ]);
       
       $roomId = Room::orderBy('created_at', 'desc')->first()->id;
       (new RoomImagesController)->storeImage($request, $roomId);
   
       
       //
       if(Auth::user()->role == UserRoleEnum::User) {
            return redirect('/home');
       }
       else{
            return redirect('/admin');
       }
       
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $room = Room::find($id);
        return view('User/editRoom',['room'=> $room]);//
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        $room = Room::find($request->id);
        $room->name = $request->name;
        $room->location = $request->location;
        $room->description = $request->description;
        $room->price = $request->price;
        $room->capacity = $request->capacity;

        $room->save();
        return redirect('/viewOwnedRoom');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
    }

    public function approveRoom($id) {
        $room = Room::find($id);
        $room->approve = true;
        $room->save();

        return redirect()->back();
    }

    public function deleteRoom($id) {
        
        Room::where('id', $id)->delete();
        
        return redirect()->back();
    }
}
