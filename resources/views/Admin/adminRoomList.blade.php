@extends('layouts.adminLayout')
@section('title') Admin Panel @endsection
<?php
$bookings = ['','']
?>
@section('main_content')
    <div>
        <a href="/apply" class="pointer-cursor no-underline absolute right-0 mr-6 mt-2 text-xl text-color hover:text-teal-500">+ Add Room</a>
        <div>
            <h2>Available Room</h2>
            <div class="fullListBox">
                @foreach($availableRoomsDetails as $roomDetails)
                <div class="p-card p-2 h-12rem w-full border-round">
                    <div class="flex flex-wrap">
                      <div class="p-card-title w-full">{{$roomDetails->name}}</div>
                      <div class="p-card-subtitle w-full">Location: {{$roomDetails->location}}</div>
                      <div class="p-card-subtitle w-6">Price: {{$roomDetails->price}}</div>
                      <div class="p-card-subtitle w-6">Capacity: {{$roomDetails->capacity}}</div>
                      <div class="p-card-subtitle">Description: {{$roomDetails->description}}</div>
                    </div>
                    <div class="flex flex-row gap-1 justify-content-end">
                        <button class="p-button p-button-success p-1" ><a href="/editRoom/{{$roomDetails->id}}" class="text-0"><i class="pi pi-pencil p-1"></i></a></button>
                        <button class="p-button p-button-danger p-button-success p-1" ><a href="/deleteRoom/{{$roomDetails->id}}" class="text-0"><i class="pi pi-trash p-1"></i></a></button>
                    </div>  
                </div>
                @endforeach
            </div>
        </div>
        <br>
        <br>
        <div>
            <h2>Unavailable Room</h2>
            <div class="fullListBox">
                @foreach($unavailableRoomsDetails as $roomDetails)
                <div class="p-card p-2 h-12rem w-full border-round">
                    <div class="flex flex-wrap">
                      <div class="p-card-title w-full">{{$roomDetails->name}}</div>
                      <div class="p-card-subtitle w-full">Location: {{$roomDetails->location}}</div>
                      <div class="p-card-subtitle w-6">Price: {{$roomDetails->price}}</div>
                      <div class="p-card-subtitle w-6">Capacity: {{$roomDetails->capacity}}</div>
                      <div class="p-card-subtitle">Description: {{$roomDetails->description}}</div>
                    </div>
                    <div class="flex flex-row gap-1 justify-content-end">
                        <button class="p-button p-button-success p-1" ><a href="/editRoom/{{$roomDetails->id}}" class="text-0"><i class="pi pi-pencil p-1"></i></a></button>
                        <button class="p-button p-button-danger p-button-success p-1" ><a href="/deleteRoom/{{$roomDetails->id}}" class="text-0"><i class="pi pi-trash p-1"></i></a></button>
                    </div>  
                </div>
                @endforeach
            </div>
        </div>
        <br><br>
        <div>
            <h2>Room Request</h2>
            <div class="fullListBox">
                @foreach($roomsDetails as $roomDetails)
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
            </div>
        </div>
    </div>
@endsection