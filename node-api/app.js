const express = require('express');

//Config
const port = 3000;
const hostname = 'localhost';

const app = express();

app.use(express.json());

//Routes
app.use(require('./src/routes'));


app.listen(port,hostname, () =>{
    console.log('Server running...');

});