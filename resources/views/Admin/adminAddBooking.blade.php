@extends('layouts.adminLayout')
@section('title') Admin Panel @endsection


@section('main_content')
<div class="container">
    <h1 class="text-white mb-5">Add booking</h1>
    <form action="/bookingConfirmation" method="POST">
        @csrf
        <div>
            <label class="h3 m-2" for="userDropdown">Select User:</label>
            <select name="user_id" id="userDropdown" aria-placeholder="Choose User">
                @foreach ($userName as $user)
                    <option value="{{$user->id}}">{{$user->email}} - {{$user->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="h3 m-2" for="roomDropdown">Select Room:</label>
            <select name="room_id" id="roomDropdown" aria-placeholder="Choose User">
                @foreach ($roomList as $room)
                    <option value="{{$user->id}}">{{$room->name}} - RM{{$room->price}}/Day</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="h3 m-2" for="date">Select Start Date:</label>
            <div class="input-group date" id="datepicker1">
                <input autocomplete="off" type="text" class="form-control" id="date" placeholder="From" name="start_date" id="start_date"/>
                <span class="input-group-append">
                <span class="input-group-text bg-light d-block" placeholder="to">
                    <i class="fa fa-calendar"></i>
                </span>
                </span>
            </div>
        </div>
        <br>
        <div class="form-group">
            <label class="h3 m-2" for="date">Select End Date:</label>
            <div class="input-group date " id="datepicker2">
                <input autocomplete="off" type="text" class="form-control" id="date"  placeholder="To" name="end_date" id="end_date"/>
                <span class="input-group-append">
                <span class="input-group-text bg-light d-block">
                    <i class="fa fa-calendar"></i>
                </span>
                </span>
            </div>
        </div>
        <br>
        @if ($errors->any())
            <div class="row py-3">
                <div class="col-12">
                    <div class="alert alert-danger pt-3 pb-1  mt-3 mp-2">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif
        <button type="submit">Add Booking</button>
    </form>
</div>
@endsection