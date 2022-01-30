import { AppBar, Button, Card, Checkbox, FormControl, FormControlLabel, FormGroup, FormLabel, Grid, InputLabel, MenuItem, Radio, RadioGroup, TextField, Toolbar, Typography } from '@mui/material';
import axios from 'axios';
import { format } from 'date-fns';
import React, { useEffect } from 'react';
import Input from 'react-phone-number-input/input'
export default function Index(props) {

    // const [customer, setCustomer] = React.useState({ name: '', dob: '', phone_number: '', gender: '', address: '' });
    const genders = ['male', 'female'];

    const [fields, setFields] = React.useState([]);
    const [viewName, setViewName] = React.useState('');
    const [customerId, setCustomerId] = React.useState('');

    const [name, setName] = React.useState('');
    const [date, setDate] = React.useState(format(new Date(), 'yyyy-MM-dd'));
    const [gender, setGender] = React.useState(genders[0]);
    const [phone, setPhone] = React.useState('');
    const [address, setAddress] = React.useState('');
    const [email, setEmail] = React.useState('');


    useEffect(() => {
        axios.get('/api/user').then(response => {
            setName(response.data.name)
            setCustomerId(response.data.id)
            setViewName(response.data.name)

            return axios.get(`/api/v1/customers/${response.data.id}`)
        }).then(response => {
            setDate(format(new Date(response.data.data.dob), 'yyyy-MM-dd'))
            setAddress(response.data.data.address)
            response.data.data.gender != null && setGender(response.data.data.gender)
            setPhone(response.data.data.phone)
            setEmail(response.data.data.email)
        })

        axios.get('/api/v1/fields').then(response => {
            setFields(response.data.data)
        })


    }, [])

    const handleChange = (event, index = 0, type) => {
        if (type == 'checkbox') {
            let data = [...fields];
            console.log( data[index].customers[data[index].customers.findIndex(x=>x.id==customerId)].pivot.view,event.target.checked)
            data[index].customers[data[index].customers.findIndex(x=>x.id==customerId)].pivot.view = String(event.target.checked)
            setFields(data)
            console.log(fields)
        }
        else if (type == 'Name') {
            setName(event.target.value)
        }
        else if (type == 'DOB') {
            setDate(event.target.value)
        }
        else if (type == 'Gender') {
            setGender(event.target.value)
        }
        else if (type == 'Address') {
            setAddress(event.target.value)
        }
        else if (type == 'Phone Number') {
            setPhone(event.target.value)
        }
        else if (type == 'Email') {
            setEmail(event.target.value)
        }

    }

    const submit = () => {
        axios.put(`/api/v1/customers/${customerId}`, {
            name,
            date,
            address,
            phone,
            gender,
            email,
            fields
        }).then(response => {

        })
    }

    return (
        <div>

            <AppBar
                position="fixed"
            >
                <Toolbar>
                    <Typography variant="h6" style={{ flexGrow: '1' }}>
                        Laravel Practical Test
                    </Typography>
                    <form action="/logout" method="POST">
                        <input type="hidden" name="_token" value={document.head.querySelector('meta[name="csrf-token"]').content} />
                        <Button
                            style={{ outline: "none" }}
                            color="inherit" type="submit">Logout</Button>
                    </form>
                </Toolbar>
            </AppBar>
            <Card style={{ marginTop: '25vh', padding: '25px' }}>
                <Grid container>
                    <Grid item xs={12}>
                        <center>
                            <Typography>Welcome {viewName}</Typography>
                        </center>
                    </Grid>

                    {fields.map((field, index) =>
                    (

                        <Grid item xs={12 / fields.length} key={field.id}>
                            <center>
                                <FormControlLabel control={
                                    <Checkbox
                                        checked={field.customers[field.customers.findIndex(x=>x.id==customerId)].pivot.view == 'true' ? true : false}
                                        onChange={(e) => handleChange(e, index, 'checkbox')}
                                        inputProps={{ 'aria-label': 'controlled' }} />}
                                    label={field.name} />
                            </center>
                        </Grid>
                    )
                    )}
                    {fields.map(field =>
                    (
                        field.customers[field.customers.findIndex(x=>x.id==customerId)].pivot.view == 'true' &&
                        <Grid item xs={12} key={field.id}>
                            <center>
                                <TextField
                                    value={
                                        field.name == 'Name' ? name :
                                            field.name == 'DOB' ? date :
                                                field.name == 'Gender' ? gender :
                                                    field.name == 'Phone Number' ? phone :
                                                        field.name == "Address" ? address :
                                                            field.name == "Email" && email
                                    }
                                    multiline={field.type == 'multiline'}
                                    select={field.type == 'select'}
                                    rows={field.type == 'multiline' ? 4 : ''}
                                    style={{ width: "25%" }}
                                    type={field.type}
                                    variant="outlined"
                                    margin="normal"
                                    onChange={(e) => handleChange(e, '', field.name)}
                                    label={field.name} >
                                    {field.type == 'select' && genders.map(gender => (
                                        <MenuItem value={gender} key={gender}>
                                            {gender}
                                        </MenuItem>
                                    ))}
                                </TextField>


                            </center>
                        </Grid>
                    )
                    )}
                    <Grid item xs={12}>
                        <center>
                            <Button variant='contained' onClick={submit}>Submit</Button>
                        </center>
                    </Grid>
                </Grid>
            </Card>
        </div>

    )
}