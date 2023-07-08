import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { Row, Col, CardGroup, Card, CardBody, CardTitle, CardText, CardImg, Button } from 'reactstrap';
import dateFormat from 'dateformat';

export default class UserHome extends Component {
    constructor(){
        super()
        this.state = {
            //
        }
    }
    render() {
        return (
            <div className="container">
                <Row><h1>-- Welcome ---</h1></Row>
                <Row>
                    <Col sm="4">
                        <Card body>
                            <CardImg
                                alt="Card image cap"
                                src="https://picsum.photos/318/180"
                                top
                                width="8%"
                            />
                            <CardBody>
                                <CardTitle tag="h5">Create Booking</CardTitle>
                                <CardText>book a meeting room.</CardText>
                            </CardBody>
                            <Button color="primary" onClick={event =>  window.location.href='/create'}>Create</Button>
                        </Card>
                    </Col>{"  "}
                    <Col sm="4">
                        <Card body>
                            <CardImg
                                alt="Card image cap"
                                src="https://picsum.photos/318/180"
                                top
                                width="10%"
                            />
                            <CardBody>
                                <CardTitle tag="h5">My Booking</CardTitle>
                                <CardText>view and cheking your booking status</CardText>
                            </CardBody>
                            <Button color="primary">View</Button>
                        </Card>
                    </Col>
                </Row>
            </div>
        );
    }
}

if (document.getElementById('userhome')) {
    ReactDOM.render(<UserHome />, document.getElementById('userhome'));
}

