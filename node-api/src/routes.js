const { json } = require('express');
const express = require('express');
const router = express.Router();
const jwt = require('jsonwebtoken');

const connection = require('./connection');


router.post('/login', (req, res) =>{

    if(connection){
        connection.query('SELECT * FROM users where username = ? AND password = ? ', 
        [req.body.username,req.body.password],
         (err, rows) =>{
            if(!err && rows.length > 0){
                const user = rows[0];

                jwt.sign({user}, 'secretKey123.',(err, token) =>{
                    res.json({
                        token
                    })
                })
            }
            else
                res.status(404).json({msg: err, code: 403})    

        })
    }
})


//Get all clients
router.get('/clients', verifyToken,  (req,res) =>{


    jwt.verify(req.token, 'secretKey123.', (err, authuser) =>{
        if(err)
            res.sendStatus(403);
        else{
            if(connection){
                connection.query('SELECT * FROM clients order by id', (err, rows) =>{
                    if(!err)
                        res.json({items: rows});
                    else
                        res.status(404).json({msg: err, code: 400})    
                })
            }
        }
    })
});

//Get an client
router.get('/client/:id',  verifyToken, (req,res) =>{
    jwt.verify(req.token, 'secretKey123.', (err, authuser) =>{
        if(err)
            res.sendStatus(403);
        else{
            if(connection){
                connection.query('SELECT * FROM clients WHERE id = ?', req.params.id,(err, rows) =>{
                    if(!err)
                        res.json({items: rows[0]});
                    else
                        res.status(404).json({msg: err, code: 400})    
                })
            }
        }
    })
});


//Create an client
router.post('/client', verifyToken,(req, res) =>{
    jwt.verify(req.token, 'secretKey123.', (err, authuser) =>{
        if(err)
            res.sendStatus(403);
        else{
 
            const clientData = req.body;
        
            if(connection){
                connection.query('INSERT INTO clients SET ?', clientData,(err, rows) =>{
                    if(!err)
                        res.json({msg: 'client '+ req.body.name + ' created with id: '+ rows.insertId});
                    else
                        res.status(404).json({msg: err, code: 400})    
                })
            }
        }
    })
});

//Update an client
router.put('/client/:id',verifyToken, (req, res) =>{
 
    jwt.verify(req.token, 'secretKey123.', (err, authuser) =>{
        if(err)
            res.sendStatus(403);
        else{
 
            const id = req.params.id;
            const clientData = req.body;
        
            if(connection){
                connection.query('UPDATE clients SET name = ?, last_name_p= ?, last_name_m = ?, address= ?, email= ? WHERE id = ?', 
                [clientData.name,clientData.last_name, clientData.last_name_m,clientData.address, clientData.email, id],
                (err, rows) =>{
                    if(!err)
                        res.json({msg: 'client '+ req.body.name + ' updated. '});
                    else
                        res.status(404).json({msg: err, code: 400})    
                })
            }
        }
    })
});


//Delete an clients
router.delete('/client/',verifyToken,(req,res) =>{

    jwt.verify(req.token, 'secretKey123.', (err, authuser) =>{
        if(err)
            res.sendStatus(403);
        else{
            const id = req.body.id;

            if(connection){
                connection.query('DELETE FROM clients WHERE id = ?', id,(err, rows) =>{
                    if(!err)
                        res.json({msg: 'client deleted'});
                    else
                        res.status(404).json({msg: err, code: 400})    
                })
            }
        }
    })
});


function verifyToken(req, res, next){
    const headerToken = req.headers['authorization'];

    if(typeof(headerToken) !== 'undefined'){
        const token = headerToken.split(" ")[1];
        req.token = token;
        next();
    }
    else{
        res.sendStatus(403);
    }

}

module.exports = router;