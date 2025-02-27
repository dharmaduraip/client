//Author Niresh Kumar
var config = require('./config.js');
var mysql = require('mysql');

var db_config = {
	connectionLimit : 10,
  	host: config.db.host,
    user: config.db.user,
    password: config.db.password,
    database: config.db.database
};

var pool;

pool  = mysql.createPool(db_config);

pool.getConnection(function(err, connection) {
  // connected! (unless `err` is set)
  connection.release();
});

module.exports = pool;