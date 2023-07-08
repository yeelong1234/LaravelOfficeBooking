@extends('layouts.adminLayout')
@section('title') Admin Panel @endsection
<?php
$bookings = ['','']
?>
@section('main_content')

    <div class="mx-5 my-2">
        <a href="/addBooking" class="pointer-cursor no-underline absolute right-0 mr-6 mt-2 text-xl text-blue-300 hover:text-teal-500">+ Add Booking</a>
        <br>
        <div>
            <h2>Not Started Booking</h2>
            <div class="fullListBox">
                @foreach ($bookingList[0] as $booking)
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
            </div>
        </div>
        <br><br>
        <div>
            <h2>Ongoing Booking</h2>
            <div class="fullListBox">
                @foreach ($bookingList[1] as $booking)
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
            </div>
        </div>
        <br><br>
        <div> 
            <h2>Completed Booking</h2>
            <div class="fullListBox">
                @foreach ($bookingList[2] as $booking)
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
            </div>
        </div>
        <br><br>
        <div>
            <h2>Cancelled Booking</h2>
            <div class="fullListBox">
                @foreach ($bookingList[3] as $booking)
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
            </div>
        </div>
    </div>
    @endsection