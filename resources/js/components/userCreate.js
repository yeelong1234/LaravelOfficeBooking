import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { Form, FormGroup, Col, Button, Input, Label } from 'reactstrap';
import axios from 'axios';
import dateFormat from 'dateformat';


export default class UserCreate extends Component {
    constructor(props){
        super(props);
        
        this.state = {
            data: JSON.parse(this.props.data),
            bookings: [],
            available: true,
            status: 1,
            newBookingData: {host_id: "", purpose: "", pax: "", level_id: "", start_date: "", start_time: "", 
            duration: "", end_time: "", meeting_room_id: "" , status_id: 1},
        }
    }
    checkAvailable(booking_id, meeting_room, start_date, start_time, end_time){
        let allow = true;
        
        // change the time into minutes
        const startTimeParts = start_time.split(":");
        let startTime = parseInt(startTimeParts[0]) * 60 + parseInt(startTimeParts[1]);

        const endTimeParts = end_time.split(":");
        let endTime = parseInt(endTimeParts[0]) * 60 + parseInt(endTimeParts[1]);

        let records = this.state.data.bookings.map((record) => {
            // change the time into minutes
            const curr_startTimeParts = ((record.start_time).toString()).split(":");
            let curr_startTime = parseInt(curr_startTimeParts[0]) * 60 + parseInt(curr_startTimeParts[1]);

            const curr_endTimeParts = ((record.end_time).toString()).split(":");
            let curr_endTime = parseInt(curr_endTimeParts[0]) * 60 + parseInt(curr_endTimeParts[1]);

            // if booking_id is not same
            if(record.id != booking_id){
                console.log("different booking")
                console.log(booking_id)
                // if booking meeting room is same
                if(parseInt(record.meeting_room_id) == parseInt(meeting_room)){
                    console.log("same meeting room")
                    console.log(meeting_room)
                    // if date is same
                    if((record.start_date).toString() == start_date){
                        console.log("same date")
                        console.log(start_date)
                        // check crash time or not
                        if(endTime > curr_startTime){
                            console.log("crash time")
                            // check within duration or not
                            if(startTime < curr_endTime){
                                console.log("within duration")
                                    allow = false
                            }
                        }
                    }
                }
            }
        })
        return allow;
    }
    addBooking(){
        let available = this.checkAvailable(0,this.state.newBookingData.meeting_room_id, (this.state.newBookingData.start_date).toString(), this.state.newBookingData.start_time, this.state.newBookingData.end_time)
        
        if (available){
            axios.post('http://127.0.0.1:8000/api/booking', this.state.newBookingData).then((response) => {
                let {bookings} = this.state
                this.setState({
                    bookings: [],
                    available: true,
                    status: 1,
                    newBookingData: {host_id: "", purpose: "", pax: "", level_id: "", start_date: "", start_time: "", 
                    duration: "", end_time: "", meeting_room_id: "" , status_id: 1},
                })
            })
            location.replace("home");
        }
        else{
            alert("This timeslot is not available. Please choose another timeslot or meeting_room.");
        }
    }
    render() {
        let status = this.state.data.statuses.map((s) => {
            return (
                <option key={s.id} value={s.id}>{s.status}</option>
            )
        })
        let rooms = this.state.data.rooms.map((r) => {
            return (
                <option key={r.id} value={r.id}>{r.name}</option>
            )
        })
        let levels = this.state.data.levels.map((l) => {
            return (
                <option key={l.id} value={l.id}>{l.level}</option>
            )
        })
        return (
            <div className="container">
                <h1>Create Booking</h1>
                <Form>
                    <FormGroup row>
                        <Label for="host_id" sm={2}>Host ID</Label>
                        <Col sm={10}>
                        <Input
                            id="host_id"
                            name="host_id"
                            placeholder="host ID"
                            onChange={(e) => {
                                    let { newBookingData } = this.state
                                    newBookingData.host_id = e.target.value
                                    this.setState({newBookingData})
                            }}
                            type="number"
                        />
                        </Col>
                    </FormGroup>
                    <FormGroup row>
                        <Label for="purpose" sm={2}>Purpose</Label>
                        <Col sm={10}>
                        <Input
                            id="purpose"
                            name="purpose"
                            placeholder="your meeting's purpose"
                            onChange={(e) => {
                                    let { newBookingData } = this.state
                                    newBookingData.purpose = e.target.value
                                    this.setState({newBookingData})
                            }}
                            type="textarea"
                        />
                        </Col>
                    </FormGroup>
                    <FormGroup row>
                        <Label for="pax" sm={2}>Pax</Label>
                        <Col sm={10}>
                        <Input
                            id="pax"
                            name="pax"
                            placeholder="number of pax"
                            onChange={(e) => {
                                    let { newBookingData } = this.state
                                    newBookingData.pax = e.target.value
                                    this.setState({newBookingData})
                            }}
                            type="number"
                        />
                        </Col>
                    </FormGroup>
                    <FormGroup row>
                        <Label for="level" sm={2}>Level</Label>
                        <Col sm={10}>
                        <Input
                            id="level"
                            name="level"
                            onChange={(e) => {
                                    let { newBookingData } = this.state
                                    newBookingData.level_id = e.target.value
                                    this.setState({newBookingData})
                            }}
                            type="select"
                        >
                            {levels}
                        </Input>
                        </Col>
                    </FormGroup>
                    <FormGroup row>
                        <Label for="start-date" sm={2}>Start Date</Label>
                        <Col sm={10}>
                        <Input
                            id="start-date"
                            name="start-date"
                            onChange={(e) => {
                                    let { newBookingData } = this.state
                                    newBookingData.start_date = e.target.value
                                    dateFormat(newBookingData.start_date, "yyyy-mm-dd")
                                    this.setState({newBookingData})
                            }}
                            type="date"
                        />
                        </Col>
                    </FormGroup>
                    <FormGroup row>
                        <Label for="start-time" sm={2}>Start Time</Label>
                        <Col sm={10}>
                        <Input
                            id="start-time"
                            name="start-time"
                            placeholder="HH:MM (24 hours format)"
                            onChange={(e) => {
                                    let { newBookingData } = this.state
                                    newBookingData.start_time = e.target.value
                                    this.setState({newBookingData})
                            }}
                            type="text"
                        />
                        </Col>
                    </FormGroup>
                    <FormGroup row>
                        <Label for="end-time" sm={2}>End Time</Label>
                        <Col sm={10}>
                        <Input
                            id="end-time"
                            name="end-time"
                            placeholder="HH:MM (24 hours format)"
                            onChange={(e) => {
                                    let { newBookingData } = this.state
                                    newBookingData.end_time = e.target.value
                                    this.setState({newBookingData})
                            }}
                            type="text"
                        />
                        </Col>
                    </FormGroup>
                    <FormGroup row>
                        <Label for="meeting-room" sm={2}>Meeting Room</Label>
                        <Col sm={10}>
                        <Input
                            id="meeting-room"
                            name="meeting-room"
                            onChange={(e) => {
                                    let { newBookingData } = this.state
                                    newBookingData.meeting_room_id = e.target.value
                                    this.setState({newBookingData})
                            }}
                            type="select"
                        >
                            {rooms}
                        </Input>
                        </Col>
                    </FormGroup>
                    <FormGroup row>
                        <Label for="status" sm={2}>Status</Label>
                        <Col sm={10}>
                        <Input
                            id="status"
                            name="status"
                            value={this.state.status}
                            onChange={(e) => {
                                    let { newBookingData } = this.state
                                    newBookingData.status_id = 1
                                    this.setState({newBookingData})
                            }} 
                            type="select"
                        >
                            {status}
                        </Input>
                        </Col>
                    </FormGroup>
                </Form>
                <Button color="primary" onClick={this.addBooking.bind(this)}>Submit</Button>
            </div>
        );
    }
}

if (document.getElementById('usercreate')) {
    var data = document.getElementById('usercreate').getAttribute('data');
    ReactDOM.render(<UserCreate data={data}/>, document.getElementById('usercreate'));
}
