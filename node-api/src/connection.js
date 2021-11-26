const mysql = require('mysql');

const connection = mysql.createConnection({
    port: 3306,
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'nodeapi'
});

connection.connect((err) =>{
    const msg = err ? 'DB cant connect. Error: ' + JSON.stringify(err,undefined,2) : 'Conecction succes';

    console.log(msg);
})

module.exports = connection;
