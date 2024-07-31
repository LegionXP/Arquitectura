// logica del login funcional con mySQL

const mysql = require('mysql');
const connection = mysql.createConnection({ // conexion a la base de datos mySQL
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'pruebalogin'
});

connection.connect((err) => {
    if (err) throw err;
    console.log('Connected!');
});

connection.query('SELECT * FROM users', (err, result) => {
    if (err) throw err;
    console.log(result);
});

connection.end(); // cerrar la conexion a la base de datos