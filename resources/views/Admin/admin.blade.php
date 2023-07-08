@extends('layouts.adminLayout')
@section('title') Admin Panel @endsection
<?php
$bookings = ['','']
?>

@section('main_content')
    <div>
        <div class="grid ml-6">
            <div class ="col-6">
                <div>
                    <h2>Latest Booking</h2>
                    <div class="h-20rem listBox">
                        @foreach ($latestBookings as $booking)
                            <div class="p-card p-2 h-10rem w-full">
                                <div>
                                    <div class="p-card-title">Name: {{$booking->name}}</div>
                                    <div class="p-card-subtitle">Room: {{$booking->room}}</div>
                                    <div class="p-card-subtitle">Duration: {{substr($booking->start_date, 0, 10)}} - {{substr($booking->end_date, 0, 10)}}</div>
                                </div>
                                <div class="flex flex-row gap-1 justify-content-end">
                                    <button class="p-button p-1" ><a href="/bookings/{{$booking->id}}/view" class="text-0"><i class="pi pi-book p-1"></i></a></button>
                                    <button class="p-button p-button-success p-1" ><a href="/bookings/{{$booking->id}}/edit" class="text-0"><i class="pi pi-pencil p-1"></i></a></button>
                                    <button class="p-button p-button-danger p-button-success p-1" ><a href="/bookings/{{$booking->id}}/delete" class="text-0"><i class="pi pi-trash p-1"></i></a></button>
                                </div>
                            </div>
                        @endforeach
                        <a href="" class="no-underline text-cyan-900">End Here...</a>
                    </div>
                    <h2 class="mt-2">Room Request</h2>
                    <div class="h-16rem listBox">

                        @foreach ($roomsDetails as $roomDetails)
                        <div class="p-card p-2 h-12rem w-full border-round">
                            <div class="flex flex-wrap">
                            <div class="p-card-title w-full">{{$roomDetails->name}}</div>
                            <div class="p-card-subtitle w-full">Location: {{$roomDetails->location}}</div>
                            <div class="p-card-subtitle w-6">Price: {{$roomDetails->price}}</div>
                            <div class="p-card-subtitle w-6">Capacity: {{$roomDetails->capacity}}</div>
                            <div class="p-card-subtitle">Description: {{$roomDetails->description}}</div>
                            </div>
                            <div class="flex flex-row gap-1 justify-content-end">
                                <button class="p-button p-button-success p-1"><a class="text-white" href="{{ route('room.approve', $roomDetails->id) }}"><i class="pi pi-check p-1"></i></a></button>
                                <button class="p-button p-button-danger p-button-success p-1" ><a class="text-white" href="{{ route('room.delete', $roomDetails->id) }}"><i class="pi pi-times p-1"></i></a></button>
                            </div>  
                        </div>
                        @endforeach
                        <a href="" class="no-underline text-cyan-900">End Here...</a>
                    </div> 
                </div>
            </div>
            <div class="col-6">
                <div class="hi"> 
                    <h2 class="w-full">Booking Summary</h2>
                    <div class="grid">
                        <div class="summuryBox bg-blue-200">
                            <h3 class="pt-1 pl-3">Today's Booking</h3>
                            <h3 class="absolute right-0 pr-3 top-50" >{{$todayBooking}}</h3>
                        </div>
                        <div class="summuryBox bg-green-200">
                            <h3 class="pt-1 pl-3">Available Seats</h3>
                            <h3 class="absolute right-0 pr-3 top-50" >{{$availableSeats}}</h3>
                        </div>
                        <div class="summuryBox bg-yellow-200">
                            <h3 class="pt-1 pl-3">Room Request</h3>
                            <h3 class="absolute right-0 pr-3 top-50" >{{$countRoomList}}</h3>
                        </div>
                        <div class="summuryBox bg-red-200">
                            <h3 class="pt-1 pl-3">Total Sales</h3>
                            <h3 class="absolute right-0 pr-3 top-50" >RM {{$totalSales}}</h3>
                        </div>
                    </div>
                </div>
                <div class="grid">
                    <h2 class="col-12">Quick Actions</h2>
                    <button class="buttonStyle">
                        <a href="/addBooking" class="text-color">
                            <span class="pi pi-book">
                            <span class="font-bold">Add Booking</span>
                        </a>
                    </button>
                    <button class="buttonStyle">
                        <a href="/apply" class="text-color">
                            <span class="pi pi-home">
                            <span class="font-bold">Add Room</span>
                        </a>
                    </button>
                    <button class="buttonStyle">
                        <a href="/bookingList" class="text-color">
                            <span class="pi pi-home">
                            <span class="font-bold">Booking List</span>
                        </a>
                    </button>
                    <button class="buttonStyle">
                        <a href="/roomList" class="text-color">
                            <span class="pi pi-home">
                            <span class="font-bold">Room List</span>
                        </a>
                    </button>
                    <button class="buttonStyle">
                        <a href="/register" class="text-color">
                            <span class="pi pi-user-plus">
                            <span class="font-bold">Add User</span>
                        </a>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection