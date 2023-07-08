import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { Table, Button } from 'reactstrap';
import dateFormat from 'dateformat';
import {Form, FormGroup, Col, Input, Label, Modal, ModalHeader, ModalBody, ModalFooter} from 'reactstrap';
import axios from 'axios';

export default class AdminHome extends Component {
    constructor(props){
        super(props)
        // console.log('data from component', JSON.parse(this.props.data));
        this.state = {
            data: JSON.parse(this.props.data),
            bookings: [],
            status: 1,
            available: true,
            newBookingData: {host_id: "", purpose: "", pax: "", level_id: "", start_date: "", start_time: "", 
            end_time: "", meeting_room_id: "" , status_id: 1},
            updateBookingModal: false,
            updateBookingData: {id: "", host_id: "", purpose: "", pax: "", level_id: "", start_date: "", start_time: "", 
            end_time: "", meeting_room_id: "" , status_id: 1},
            updateNotiModal: false,
            deleteNotiModal: false,
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
    loadBooking(){
        axios.get('http://127.0.0.1:8000/api/bookings').then((response) => {
            this.setState({
                bookings:response.data
            })
        })
    }
    componentWillMount() {
        this.loadBooking();
    }
    toggleUpdateBookingModal(id, host_id, purpose, pax, level_id, start_date, start_time, end_time, meeting_room_id, status_id) {
        this.setState({
            updateBookingData: {id, host_id, purpose, pax, level_id, start_date, start_time, end_time, meeting_room_id, status_id},
            updateBookingModal: !this.state.updateBookingModal,
        });
    }
    toggleUpdateModal() {
        this.setState({
            updateNotiModal: false,
        });
    }
    toggleDeleteModal() {
        this.setState({
            deleteNotiModal: false,
        });
    }
    updateBooking(){
        let available = this.checkAvailable(this.state.updateBookingData.id,this.state.updateBookingData.meeting_room_id, (this.state.updateBookingData.start_date).toString(), this.state.updateBookingData.start_time, this.state.updateBookingData.end_time)
        if (available) {
            let {id, host_id, purpose, pax, level_id, start_date, start_time, end_time, meeting_room_id, status_id} = this.state.updateBookingData;
            axios.put('http://127.0.0.1:8000/api/bookings/update/'+id, {host_id, purpose, pax, level_id, start_date, start_time, end_time, meeting_room_id, status_id}).then((response) => {
                this.setState({
                    updateNotiModal: true,
                    updateBookingData: {id: "", host_id: "", purpose: "", pax: "", level_id: "", start_date: "", start_time: "",  
                    end_time: "", meeting_room_id: "" , status_id: 1},
                    updateBookingModal: false,
                });
                this.loadBooking();
            })
        } else {
            alert("This timeslot is not available. Please choose another timeslot or meeting_room.");
        }
    }
    deleteBooking(id) {
        axios.delete('http://127.0.0.1:8000/api/bookings/delete/'+id).then((response) => {
            this.setState({
                deleteNotiModal: true,
                deleteBookingModal: true,
            });
            this.loadBooking();
        });
    }
    render() {
        let bookings = this.state.bookings.map((booking) => {

            let status_id = booking.status_id
            let status_name = "";
            if (status_id=='1') {
                status_name = <td>Pending</td>
              }
            else if (status_id=='2'){
                status_name = <td>Approve</td>
            }
            else if (status_id=='3'){
                status_name = <td>Cancel</td>
            }
            else if (status_id=='4'){
                status_name = <td>Deny</td>
            }
            else {
                status_name = <td>{booking.status_id}</td>
            }

            return (
                <tr key={booking.id}>
                    <td>{booking.id}</td>
                    <td>{booking.host_id}</td>
                    <td>{booking.start_date}</td>
                    { status_name }
                    <td>
                        <Button onClick={this.toggleUpdateBookingModal.bind(this, booking.id, booking.host_id, booking.purpose, booking.pax, booking.level_id, 
                            booking.start_date, booking.start_time, booking.end_time, booking.meeting_room_id, booking.status_id)} color="success" size="sm">
                        Edit</Button>{'  '}
                        <Button onClick={this.deleteBooking.bind(this, booking.id)} color="danger" size="sm">
                        Delete</Button>
                    </td>
                </tr>
            )
        })

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
                <Table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Host ID</th>
                            <th>Booking Date</th>
                            <th>Status</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        {bookings}
                    </tbody>
                </Table>

                <Modal isOpen={this.state.updateBookingModal} toggle={this.toggleUpdateBookingModal.bind(this)}>
                    <ModalHeader>Update Booking</ModalHeader>
                    <ModalBody>
                        <Form>
                        <FormGroup row>
                                <Label for="host_id" sm={2}>ID</Label>
                                <Col sm={10}>
                                <Input
                                    id="host_id"
                                    name="host_id"
                                    value={this.state.updateBookingData.host_id}
                                    onChange={(e) => {
                                            let { updateBookingData } = this.state
                                            updateBookingData.host_id = e.target.value
                                            this.setState({updateBookingData})
                                    }}
                                    type="text"
                                />
                                </Col>
                            </FormGroup>
                            <FormGroup row>
                                <Label for="purpose" sm={2}>Purpose</Label>
                                <Col sm={10}>
                                <Input
                                    id="purpose"
                                    name="purpose"
                                    value={this.state.updateBookingData.purpose}
                                    onChange={(e) => {
                                            let { updateBookingData } = this.state
                                            updateBookingData.purpose = e.target.value
                                            this.setState({updateBookingData})
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
                                    value={this.state.updateBookingData.pax}
                                    onChange={(e) => {
                                            let { updateBookingData } = this.state
                                            updateBookingData.pax = e.target.value
                                            this.setState({updateBookingData})
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
                                    value={this.state.updateBookingData.level_id}
                                    onChange={(e) => {
                                            let { updateBookingData } = this.state
                                            updateBookingData.level_id = e.target.value
                                            this.setState({updateBookingData})
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
                                    value={this.state.updateBookingData.start_date}
                                    onChange={(e) => {
                                            let { updateBookingData } = this.state
                                            updateBookingData.start_date = e.target.value
                                            dateFormat(updateBookingData.start_date, "yyyy-mm-dd")
                                            this.setState({updateBookingData})
                                    }}
                                    type="date"
                                />
                                </Col>
                            </FormGroup>
                            <p>{this.state.updateBookingData.start_date}</p>
                            <FormGroup row>
                                <Label for="start-time" sm={2}>Start Time</Label>
                                <Col sm={10}>
                                <Input
                                    id="start-time"
                                    name="start-time"
                                    value={this.state.updateBookingData.start_time}
                                    onChange={(e) => {
                                            let { updateBookingData } = this.state
                                            updateBookingData.start_time = e.target.value
                                            this.setState({updateBookingData})
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
                                    value={this.state.updateBookingData.end_time}
                                    onChange={(e) => {
                                            let { updateBookingData } = this.state
                                            updateBookingData.end_time = e.target.value
                                            this.setState({updateBookingData})
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
                                    value={this.state.updateBookingData.meeting_room_id}
                                    onChange={(e) => {
                                            let { updateBookingData } = this.state
                                            updateBookingData.meeting_room_id = e.target.value
                                            this.setState({updateBookingData})
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
                                    value={this.state.updateBookingData.status_id}
                                    onChange={(e) => {
                                            let { updateBookingData } = this.state
                                            updateBookingData.status_id = e.target.value
                                            this.setState({updateBookingData})
                                    }} 
                                    type="select"
                                >
                                    {status}
                                </Input>
                                </Col>
                            </FormGroup>
                        </Form>
                    </ModalBody>
                    <ModalFooter>
                        <Button color="primary" onClick={this.updateBooking.bind(this)}>Submit</Button>
                        <Button color="danger" onClick={this.toggleUpdateBookingModal.bind(this)}>Cancel</Button>
                    </ModalFooter>
                </Modal>

                <Modal isOpen={this.state.updateNotiModal} toggle={this.toggleUpdateModal.bind(this)}>
                    <ModalHeader>Booking Successfully Updated</ModalHeader>
                    <ModalFooter>
                        <Button color="primary" onClick={this.toggleUpdateModal.bind(this)}>OK</Button>
                    </ModalFooter>
                </Modal>

                <Modal isOpen={this.state.deleteNotiModal} toggle={this.toggleDeleteModal.bind(this)}>
                    <ModalHeader>Booking Successfully Deleted</ModalHeader>
                    <ModalFooter>
                        <Button color="primary" onClick={this.toggleDeleteModal.bind(this)}>OK</Button>
                    </ModalFooter>
                </Modal>

            </div>
        );
    }
}

if (document.getElementById('adminhome')) {
    var data = document.getElementById('adminhome').getAttribute('data');
    ReactDOM.render(<AdminHome data={data}/>, document.getElementById('adminhome'));
}

