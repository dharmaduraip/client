var fs = require('fs');
var http = require('http');
var https = require('https');
// const logger = require('morgan');
// var privateKey  = fs.readFileSync('/root/ssl_new/imakan_new.key');
// var certificate = fs.readFileSync('/root/ssl_new/imakan_new.pem');
// var ca = fs.readFileSync('/root/ssl_new/origin_ca_rsa_root.pem');
var privateKey  = fs.readFileSync('/home/devabserve/public_html/ssl/private.key');
var certificate = fs.readFileSync('/home/devabserve/public_html/ssl/certificate.crt');
var ca = fs.readFileSync('/home/devabserve/public_html/ssl/ca.crt');
var credentials = {key: privateKey, cert: certificate, ca: ca};
var express = require('express');
var app = express();
// app.use(logger('dev'));

// your express configuration here

// var httpServer = http.createServer(app);
//var httpsServer = https.createServer(credentials, app);
// var httpsServer = https.createServer(credentials, app);
// var httpServer = http.createServer(app);
var httpsServer = https.createServer(credentials, app);

const io = require('socket.io').listen(httpsServer,{
  pingInterval:  1000 * 60 * 5, // ms
  pingTimeout: 1000 * 60 * 3, // ms
});

global.dir = [];

var db = require('./db.js');

io.on('connection', (socket) => {
  io.set('heartbeat timeout', 1200);   //ms
  io.set('heartbeat interval', 5000);   //ms
  var userid;
  socket.on('new order placed', function(partner_id) {   
      //intimate partner
      console.log("new order placed");
       if( !('part_'+partner_id in dir)) {
          addAck('new order placed',data,'part_'+partner_id);
       }
       else {
        var data = {
          'partner_id': partner_id
        }; 
        console.log(partner_id);
        console.log('part_'+partner_id in dir);
        dir['part_'+partner_id].socket.volatile.emit('new order placed',data,function(confirmation){
            if(!confirmation){
              addAck('new order placed',data,'part_'+partner_id);
            }
        });
       }
  });
  
  socket.on('placed the order', function(partner_id) {   
      //intimate partner
      console.log("placed the order");
       if( !('part_'+partner_id in dir)) {
          addAck('new order placed',data,'part_'+partner_id);
       }
       else {
        var data = {
          'partner_id': partner_id
        }; 
        console.log(partner_id);
        console.log('part_'+partner_id in dir);
        dir['part_'+partner_id].socket.volatile.emit('new order placed',data,function(confirmation){
            if(!confirmation){
              addAck('new order placed',data,'part_'+partner_id);
            }
        });
       }
  });
  
  socket.on('order success', function(partner_id) {   
      //intimate partner
      console.log("order success");
       if( !('part_'+partner_id in dir)) {
          addAck('new order placed',data,'part_'+partner_id);
       }
       else {
        var data = {
          'partner_id': partner_id
        }; 
        console.log(partner_id);
        console.log('part_'+partner_id in dir);
        dir['part_'+partner_id].socket.volatile.emit('new order placed',data,function(confirmation){
            if(!confirmation){
              addAck('new order placed',data,'part_'+partner_id);
            }
        });
       }
  });

  socket.on('partner accepted', function(params){    
        console.log("partner accepted");    
      var paramsobj = JSON.parse(params);
      var boy_array = paramsobj.boy_id;
      var data = {
        'customer_id': paramsobj.customer_id,
        'order_id': paramsobj.order_id,
        'partner_id': paramsobj.partner_id
      };
      boy_array.forEach((boy_id)=>{
        if( !('boy_'+boy_id in dir)){
          addAck('partner accepted',data,'boy_'+boy_id);
        }
          else  {
            dir['boy_'+boy_id].socket.emit('partner accepted',data);
          }
        if( !('cust_'+paramsobj.customer_id in dir)){
            addAck('partner accepted',data,'cust_'+paramsobj.customer_id);
         }else{
            dir['cust_'+paramsobj.customer_id].socket.emit('partner accepted',data);
         }
        });
    });

  function addAck(event,data,to){
    var query = "INSERT INTO `abserve_acknowledge` ( `event`, `data`, `emit_to` ) VALUES ( '"+event+"', '"+JSON.stringify(data)+"', '"+to+"' )";
      db.query(query,function(err,result,data){
      });
  }

  function closeAck(id){
    var query = "UPDATE `abserve_acknowledge` SET `status` = 1 WHERE `id` = '"+id+"'";
    db.query(query,function(err,result,data){});
  }

  function getAck(to,fn){
    var query = "SELECT * FROM `abserve_acknowledge` where `emit_to` =  '"+to+"' AND `status` = 0 ";
    db.query(query, function(err, result, data) {
        if (err) {
            return fn({
                status: false
            });
        }
        return fn({
            status: true,
            result: result
        });
    });
  }

  socket.on('create connection', function(user) {

    //delete dir['boy_7'];
    console.log('connect-'+user);
    if((user in dir))
    {
       //socket.emit('name taken');
       userObj = new chatUser(socket);
       userObj.socket.userKey = user;
        dir[user] = userObj; // add user to directory
        userid = user;
      } else {
        userObj = new chatUser(socket);
        userObj.socket.userKey = user;
        dir[user] = userObj; // add user to directory
        userid = user;
        //online_users.push(userId);  // add user to list of online users
        // var data = {
        //   customer_id: 45
        // };
    }
    getAck(user,function(result){
      if(result.status){
        if(result.result.length > 0){
            result.result.forEach(function(data){
          if(data!= undefined && data.data != undefined && data.data != 'undefined'){
              dir[data.emit_to].socket.emit(data.event,JSON.parse(data.data)); 
            console.log('close ack test==>'+data);
              closeAck(data.id);
       }
            });
        }
      }
    });

    // dir['part_'+partner_id].socket.emit('new order placed',data
  });
  // Customer Delete
  socket.on('customer delete', function(params){
   
    var paramsobj = JSON.parse(params);
      //intimate boy
      if(!('cust_'+paramsobj.customer_id in dir)){

      }
        else{
          
          var data = {
            'customer_id': paramsobj.customer_id
          };
          dir['cust_'+paramsobj.customer_id].socket.emit('customer delete',data);
        }
      });
  // Payment failed
  socket.on('payment failed', function(params){
   
    var paramsobj = JSON.parse(params);
      //intimate boy
      if(!('cust_'+paramsobj.customer_id in dir)){}
        else{
          
          var data = {
            'customer_id': paramsobj.customer_id,
            'order_id': paramsobj.order_id,
            'Molorder_id' : paramsobj.Molorder_id,
            'amount' : paramsobj.amount
          };
          dir['cust_'+paramsobj.customer_id].socket.emit('payment failed',data);
        }
      });
// Partner Delete
socket.on('partner delete', function(params){

  var paramsobj = JSON.parse(params);
      //intimate boy
      if(!('part_'+paramsobj.partner_id in dir)){}
        else{
          
          var data = {
            'partner_id': paramsobj.partner_id
          };
          dir['part_'+paramsobj.partner_id].socket.emit('partner delete',data);
        }
      });

// Rider Delete
socket.on('rider delete', function(params){

  var paramsobj = JSON.parse(params);
      //intimate boy
      if(!('boy_'+paramsobj.boy_id in dir)){}
        else{
          var data = {
            'boy_id': paramsobj.boy_id
          };
          dir['boy_'+paramsobj.boy_id].socket.emit('rider delete',data);
        }
      });
socket.on('customer order cancel', function(params){
      //intimate partner
      var paramsobj = JSON.parse(params);
      if( !('part_'+paramsobj.partner_id in dir)){
        addAck('customer order cancel',data,'part_'+paramsobj.partner_id);
      }
        else{
          var data = {
            'customer_id': paramsobj.customer_id,
            'order_id': paramsobj.order_id,
            'partner_id': paramsobj.partner_id
          };
          dir['part_'+paramsobj.partner_id].socket.emit('customer order cancel',data);
        }
      });

socket.on('partner rejected', function(params){
      /*global $dir;

      //intimate customer
      $aParams = json_decode($params,true);
      if(array_key_exists('cust_'.$aParams['customer_id'], $dir)) {
          $aCustomer = $dir['cust_'.$aParams['customer_id']];
          $socket->broadcast->to($aCustomer['socket_id'])->emit('partner rejected', array(
              'customer_id' => $aParams['customer_id'],
              'order_id' => $aParams['order_id'],
              'partner_id' => $aParams['partner_id']
          ));
        }*/
      //intimate customer
      var paramsobj = JSON.parse(params);
      if( !('cust_'+paramsobj.customer_id in dir)){
        addAck('partner rejected',data,'cust_'+paramsobj.customer_id);
      }
        else{
          var data = {
            'customer_id': paramsobj.customer_id,
            'order_id': paramsobj.order_id,
            'partner_id': paramsobj.partner_id
          };
          dir['cust_'+paramsobj.customer_id].socket.emit('partner rejected',data);
        }
      });

socket.on('admin rejected', function(params){
      // global $dir;

      //intimate partner
      var paramsobj = JSON.parse(params);
      if( !('cust_'+paramsobj.partner_id in dir)){
        addAck('admin rejected',data,'cust_'+paramsobj.partner_id);
      }
        else{
          var data = {
            'customer_id': paramsobj.customer_id,
            'order_id': paramsobj.order_id,
            'partner_id': paramsobj.partner_id
          };
          dir['part_'+paramsobj.partner_id].socket.emit('admin rejected',data);
        }


      //intimate customer
      var paramsobj = JSON.parse(params);
      if( !('cust_'+paramsobj.customer_id in dir)){
         addAck('admin rejected',data,'cust_'+paramsobj.customer_id);
      }
        else{
          var data = {
            'customer_id': paramsobj.customer_id,
            'order_id': paramsobj.order_id,
            'partner_id': paramsobj.partner_id
          };
          dir['cust_'+paramsobj.customer_id].socket.emit('admin rejected',data);
        }
      });

socket.on('no boys found', function(params){    
           console.log("no boys found");    
      /*global $dir;
      $aParams = json_decode($params,true);

      //intimate customer
      if(array_key_exists('cust_'.$aParams['customer_id'], $dir)) {
          $aCustomer = $dir['cust_'.$aParams['customer_id']];
          $socket->broadcast->to($aCustomer['socket_id'])->emit('no boys found', array(
              'customer_id' => $aParams['customer_id'],
              'order_id' => $aParams['order_id']
          ));
      }

      //intimate partner
      if(array_key_exists('part_'.$aParams['partner_id'], $dir)) {
          $aPartner = $dir['part_'.$aParams['partner_id']];
          $socket->broadcast->to($aPartner['socket_id'])->emit('no boys found', array(
              'partner_id' => $aParams['partner_id'],
              'order_id' => $aParams['order_id']
          ));
        }*/

        var paramsobj = JSON.parse(params);
      //intimate customer
      /*if(!('cust_'+paramsobj.customer_id in dir)){}
      else{
          var data = {
              'customer_id': paramsobj.customer_id,
              'order_id': paramsobj.order_id
          };
          dir['cust_'+paramsobj.customer_id].socket.emit('no boys found',data);
        }*/

      //intimate partner
      if(!('part_'+paramsobj.partner_id in dir)){
        addAck('no boys found',data,'part_'+paramsobj.partner_id);
      }
        else{
          var data = {
            'partner_id': paramsobj.partner_id,
            'order_id': paramsobj.order_id
          };
          dir['part_'+paramsobj.partner_id].socket.emit('no boys found',data);
        }
      });

socket.on('boy accepted', function(params){  
       console.log("boy accepted");      
      /*global $dir;
      $aParams = json_decode($params,true);

      echo 'coming boy accepted';
      var_dump($aParams);
      var_dump($dir);

      //intimate customer
      if(array_key_exists('cust_'.$aParams['customer_id'], $dir)) {
          $aCustomer = $dir['cust_'.$aParams['customer_id']];
          echo 'Triggering id ---- cust_'.$aParams['customer_id'];
          $socket->broadcast->to($aCustomer['socket_id'])->emit('boy accepted', array(
              'boy_id' => $aParams['boy_id'],
              'order_id' => $aParams['order_id'],
              'partner_name' => $aParams['partner_name'],
              'amount' => $aParams['amount']
          ));
      }

      //intimate partner
      if(array_key_exists('part_'.$aParams['partner_id'], $dir)) {
          echo 'for partner coming in';
          $aPartner = $dir['part_'.$aParams['partner_id']];
          var_dump($aPartner);
          echo 'Triggering id ---- part_'.$aParams['partner_id'];
          $socket->broadcast->to($aPartner['socket_id'])->emit('boy accepted', array(
              'boy_id' => $aParams['boy_id'],
              'order_id' => $aParams['order_id']
          ));
        }*/

        var paramsobj = JSON.parse(params);
      //intimate customer
      if(!('cust_'+paramsobj.customer_id in dir)){
        addAck('boy accepted',data,'cust_'+paramsobj.customer_id);
      }
        else{
          var data = {
            'boy_id': paramsobj.boy_id,
            'boy_name': paramsobj.bName,
            'boy_phone_number': paramsobj.bNumber,
            'order_id': paramsobj.order_id,
            'is_rapido' : paramsobj.is_rapido,
            'rapido_orderid' : paramsobj.rapido_orderid,
            'Molorder_id': paramsobj.Molorder_id,
            'partner_name': paramsobj.partner_name,
            'amount': paramsobj.amount
          };
          dir['cust_'+paramsobj.customer_id].socket.emit('boy accepted',data);
        }

      //intimate partner
      if(!('part_'+paramsobj.partner_id in dir)){
        addAck('boy accepted',data,'part_'+paramsobj.partner_id);
      }
        else{
          var data = {
            'boy_id': paramsobj.boy_id,
            'order_id': paramsobj.order_id,
            'Molorder_id': paramsobj.Molorder_id
          };
          dir['part_'+paramsobj.partner_id].socket.emit('boy accepted',data);
        }
      });

socket.on('customer paid', function(params){        
      /*global $dir;
      $aParams = json_decode($params,true);

      echo 'coming customer paid';
      var_dump($aParams);
      var_dump($dir);
      //intimate partner
      if(array_key_exists('part_'.$aParams['partner_id'], $dir)) {
          echo 'for partner coming in';
          $aPartner = $dir['part_'.$aParams['partner_id']];
          echo 'Triggering id ---- part_'.$aParams['partner_id'];
          $socket->broadcast->to($aPartner['socket_id'])->emit('customer paid', array(
              'customer_id' => $aParams['customer_id'],
              'order_id' => $aParams['order_id']
          ));
        }*/

        var paramsobj = JSON.parse(params);
      //intimate partner
      if(!('part_'+paramsobj.partner_id in dir)){}
        else{
          var data = {
            'customer_id': paramsobj.customer_id,
            'order_id': paramsobj.order_id
          };
          dir['part_'+paramsobj.partner_id].socket.emit('customer paid',data);
        }

        if(!('boy_'+paramsobj.boy_id in dir)){}
          else{
            var data = {
              'customer_id': paramsobj.customer_id,
              'order_id': paramsobj.order_id
            };
            dir['boy_'+paramsobj.boy_id].socket.emit('customer paid',data);
          }
        });
socket.on('order packing', function(params){
  console.log("order packing");
  
      //intimate customer
      var paramsobj = JSON.parse(params);
      if( !('cust_'+paramsobj.customer_id in dir)){
        addAck('order packing',data,'cust_'+paramsobj.customer_id);
      }
      else{
        var data = {
          'boy_id': paramsobj.boy_id,
          'order_id': paramsobj.order_id,
          'partner_id': paramsobj.partner_id
        };
        dir['cust_'+paramsobj.customer_id].socket.emit('order packing',data);
      }
    });

socket.on('order handovered', function(params){      
      console.log("order handovered");  
      /*global $dir;
      $aParams = json_decode($params,true);

      //intimate customer
      if(array_key_exists('cust_'.$aParams['customer_id'], $dir)) {
          $aCustomer = $dir['cust_'.$aParams['customer_id']];
          $socket->broadcast->to($aCustomer['socket_id'])->emit('order handovered', array(
              'boy_id' => $aParams['boy_id'],
              'order_id' => $aParams['order_id'],
              'partner_id' => $aParams['partner_id']
          ));
      }

      //intimate boy
      if(array_key_exists('boy_'.$aParams['boy_id'], $dir)) {
          $aBoy = $dir['boy_'.$aParams['boy_id']];
          $socket->broadcast->to($aBoy['socket_id'])->emit('order handovered', array(
              'customer_id' => $aParams['customer_id'],
              'order_id' => $aParams['order_id'],
              'partner_id' => $aParams['partner_id']
          ));
        }*/

        var paramsobj = JSON.parse(params);
      //intimate customer
      if(!('cust_'+paramsobj.customer_id in dir)){
        addAck('order handovered',data,'cust_'+paramsobj.customer_id);
      }
        else{
          var data = {
            'boy_id': paramsobj.boy_id,
            'order_id': paramsobj.order_id,
            'partner_id': paramsobj.partner_id
          };
          dir['cust_'+paramsobj.customer_id].socket.emit('order handovered',data);
        }

      //intimate boy
      if(!('boy_'+paramsobj.boy_id in dir)){
       addAck('order handovered',data,'boy_'+paramsobj.boy_id); 
      }
        else{
          var data = {
            'customer_id': paramsobj.customer_id,
            'order_id': paramsobj.order_id,
            'partner_id': paramsobj.partner_id
          };
          dir['boy_'+paramsobj.boy_id].socket.emit('order handovered',data);
        }
      });

  //cron flow
  socket.on('partner not accepted', function(params){
      /*global $dir;
      $aParams = json_decode($params,true);
      /*echo $data['partner_id'].PHP_EOL;
      echo $data['customer_id'].PHP_EOL;*/

      //intimate partner
      /*if(array_key_exists('part_'.$aParams['partner_id'], $dir)) {
          $aPartner = $dir['part_'.$aParams['partner_id']];
          $socket->broadcast->to($aPartner['socket_id'])->emit('partner not accepted', array(
              'customer_id' => $aParams['customer_id'],
              'order_id' => $aParams['order_id']
          ));
      }

      //intimate customer
      if(array_key_exists('cust_'.$aParams['customer_id'], $dir)) {
          $aCustomer = $dir['cust_'.$aParams['customer_id']];
          $socket->broadcast->to($aCustomer['socket_id'])->emit('partner not accepted', array(
              'partner_id' => $aParams['partner_id'],
              'order_id' => $aParams['order_id']
          ));
        }*/

        var paramsobj = JSON.parse(params);
      //intimate customer
      if(!('cust_'+paramsobj.customer_id in dir)){}
        else{
          var data = {
            'partner_id': paramsobj.partner_id,
            'order_id': paramsobj.order_id
          };
          dir['cust_'+paramsobj.customer_id].socket.emit('partner not accepted',data);
        }

      //intimate partner
      if(!('part_'+paramsobj.partner_id in dir)){}
        else{
          var data = {
            'customer_id': paramsobj.customer_id,
            'order_id': paramsobj.order_id
          };
          dir['part_'+paramsobj.partner_id].socket.emit('partner not accepted',data);
        }
      });

  socket.on('no boy accepted', function(params){
      /*global $dir;
      $aParams = json_decode($params,true);
      /*echo $data['partner_id'].PHP_EOL;
      echo $data['customer_id'].PHP_EOL;*/

      //intimate partner
      /*if(array_key_exists('part_'.$aParams['partner_id'], $dir)) {
          $aPartner = $dir['part_'.$aParams['partner_id']];
          $socket->broadcast->to($aPartner['socket_id'])->emit('no boy accepted', array(
              'customer_id' => $aParams['customer_id'],
              'order_id' => $aParams['order_id']
          ));
      }

      //intimate customer
      if(array_key_exists('cust_'.$aParams['customer_id'], $dir)) {
          $aCustomer = $dir['cust_'.$aParams['customer_id']];
          $socket->broadcast->to($aCustomer['socket_id'])->emit('no boy accepted', array(
              'partner_id' => $aParams['partner_id'],
              'order_id' => $aParams['order_id']
          ));
        }*/

        var paramsobj = JSON.parse(params);
      //intimate customer
      if(!('cust_'+paramsobj.customer_id in dir)){}
        else{
          var data = {
            'partner_id': paramsobj.partner_id,
            'order_id': paramsobj.order_id
          };
          dir['cust_'+paramsobj.customer_id].socket.emit('no boy accepted',data);
        }

      //intimate partner
      if(!('part_'+paramsobj.partner_id in dir)){}
        else{
          var data = {
            'customer_id': paramsobj.customer_id,
            'order_id': paramsobj.order_id
          };
          dir['part_'+paramsobj.partner_id].socket.emit('no boy accepted',data);
        }
      });

  socket.on('remove order', function(params){
      /*global $dir;
      $aParams = json_decode($params,true);
      /*echo $data['partner_id'].PHP_EOL;
      echo $data['customer_id'].PHP_EOL;*/

      //intimate boy
      /*if(array_key_exists('boy_'.$aParams['boy_id'], $dir)) {
          $aBoy = $dir['boy_'.$aParams['boy_id']];
          $socket->broadcast->to($aBoy['socket_id'])->emit('remove order', array(
              'customer_id' => $aParams['customer_id'],
              'order_id' => $aParams['order_id'],
              'partner_id' => $aParams['partner_id'],
          ));
        }*/

        var paramsobj = JSON.parse(params);
      //intimate boy
      if(!('boy_'+paramsobj.boy_id in dir)){}
        else{
          var data = {
            'customer_id': paramsobj.customer_id,
            'order_id': paramsobj.order_id,
            'partner_id': paramsobj.partner_id
          };
          dir['boy_'+paramsobj.boy_id].socket.emit('remove order',data);
        }
      });

   socket.on('boy picked', function(params){
    console.log("boypicked");
    
      //intimate customer
      var paramsobj = JSON.parse(params);
      if( !('cust_'+paramsobj.customer_id in dir)){
        addAck('boy picked',data,'cust_'+paramsobj.customer_id);
      }
      else{
        var data = {
          'boy_id': paramsobj.boy_id,
          'order_id': paramsobj.order_id,
          'partner_id': paramsobj.partner_id
        };
        dir['cust_'+paramsobj.customer_id].socket.emit('boy picked',data);
      }
    });

  socket.on('boy arrived', function(params){
    console.log("boyarrived");
    
      //intimate customer
      var paramsobj = JSON.parse(params);
      if( !('cust_'+paramsobj.customer_id in dir)){
        addAck('boy arrived',data,'cust_'+paramsobj.customer_id);
      }
      else{
        var data = {
          'boy_id': paramsobj.boy_id,
          'order_id': paramsobj.order_id,
          'partner_id': paramsobj.partner_id
        };
        dir['cust_'+paramsobj.customer_id].socket.emit('boy arrived',data);
      }
    });

  socket.on('delivered to customer', function(params){
        console.log("delivered to customer");
    
      //intimate customer
      var paramsobj = JSON.parse(params);
      if( !('cust_'+paramsobj.customer_id in dir)){
        addAck('delivered to customer',data,'cust_'+paramsobj.customer_id);
      }
        else{
          var data = {
            'boy_id': paramsobj.boy_id,
            'order_id': paramsobj.order_id,
            'partner_id': paramsobj.partner_id
          };
          dir['cust_'+paramsobj.customer_id].socket.emit('delivered to customer',data);
        }

      //intimate boy
      var paramsobj = JSON.parse(params);
      if( !('boy_'+paramsobj.boy_id in dir)){
        addAck('delivered to customer',data,'boy_'+paramsobj.boy_id); 
      }
        else{
          var data = {
            'customer_id': paramsobj.customer_id,
            'order_id': paramsobj.order_id,
            'partner_id': paramsobj.partner_id
          };
          dir['boy_'+paramsobj.boy_id].socket.emit('delivered to customer',data);
        }
      });


  socket.on('testing from php client', function(variable){
    console.log("testing working");
  });

  socket.on('payment not done', function(params){
      /*global $dir;
      $aParams = json_decode($params,true);
      /*echo $data['partner_id'].PHP_EOL;
      echo $data['customer_id'].PHP_EOL;*/

      //intimate partner
      /*if(array_key_exists('part_'.$aParams['partner_id'], $dir)) {
          $aPartner = $dir['part_'.$aParams['partner_id']];
          $socket->broadcast->to($aPartner['socket_id'])->emit('payment not done', array(
              'customer_id' => $aParams['customer_id'],
              'order_id' => $aParams['order_id']
          ));
      }

      //intimate boy
      if(array_key_exists('boy_'.$aParams['boy_id'], $dir)) {
          $aBoy = $dir['boy_'.$aParams['boy_id']];
          $socket->broadcast->to($aBoy['socket_id'])->emit('payment not done', array(
              'customer_id' => $aParams['customer_id'],
              'order_id' => $aParams['order_id']
          ));
        }*/

        var paramsobj = JSON.parse(params);

       //intimate customer
       if( !('cust_'+paramsobj.customer_id in dir)){}
        else{
          var data = {
            'customer_id': paramsobj.customer_id,
            'order_id': paramsobj.order_id,
            'partner_id': paramsobj.partner_id
          };
          dir['cust_'+paramsobj.customer_id].socket.emit('partner rejected',data);
        }
        
      //intimate partner
      if(!('part_'+paramsobj.partner_id in dir)){}
        else{
          var data = {
            'customer_id': paramsobj.customer_id,
            'partner_id': paramsobj.partner_id,
            'order_id': paramsobj.order_id
          };
          dir['part_'+paramsobj.partner_id].socket.emit('payment not done',data);
        }

      //intimate boy
      if(!('boy_'+paramsobj.boy_id in dir)){}
        else{
          var data = {
            'customer_id': paramsobj.customer_id,
            'order_id': paramsobj.order_id

          };
          dir['boy_'+paramsobj.boy_id].socket.emit('payment not done',data);
        }


      });


  //cron flow

  socket.on('disconnect', function(reason) {
    try{
        //delete dir[user.username];
          var userId = Object.values(dir).filter(function (user) { return user.socket.id == socket.id });
          if(userId.length > 0){
            var user = userId[0].socket.userKey;
            console.log('disconnect-'+user);
          }
        if(typeof user !== 'undefined') {
          delete dir[userid];
        }
      } catch(err) {
          console.log(err);
      }

    });
    socket.on('ping', function() {
      socket.emit('pong');
    });
    
    socket.on('boy current location', function(data){
    console.log('boy current location__'+data.orderId);
    var query = "UPDATE `abserve_order_details` SET `status` = 'boyArrived', `customer_status` = 'boyArrived' WHERE `id` = '"+data.orderId+"' AND `status` = 'boyPicked'";
    db.query(query, function(err, result) {
        if (err) {
            console.error('Error updating order status:', err);
            // Handle the error, e.g., send an error response to the client
        } else {
            console.log('Update successful');
            io.emit('boy live location',data);
            // Query executed successfully, do something if needed
        }
    });
    socket.emit('boy location');
});
    
    socket.on('boy reached', function(data){
        console.log('boy reached');
        var query = "UPDATE `abserve_order_details` SET `status` = 'Reached' WHERE `id` = '"+data.orderId+"' AND `status` = 'boyArrived'";
        db.query(query, function(err, result) {
            if (err) {
                console.error('Error updating order status:', err);
                // Handle the error, e.g., send an error response to the client
            } else {
                console.log('Update reached successful');
                io.emit('rider reached');
                // Query executed successfully, do something if needed
            }
        });
    });
    
    socket.on('partner order accepted', function(data){
        console.log('partner accepted order');
        io.emit('partner accepted order');
    });
    
    socket.on('boy order accepted', function(data){
        console.log('boy accepted order');
        io.emit('boy accepted order');
    });
    
    socket.on('partner order packing', function(data){
        console.log('partner packing stage');
        io.emit('partner packing stage');
    });
    
    socket.on('partner order handovered', function(data){
        console.log('partner handovered stage');
        io.emit('partner handovered stage');
    });
    
    socket.on('boy order picked', function(data){
        console.log('boy picked stage');
        io.emit('boy picked stage');
    });
    
    socket.on('delivered to customer', function(data){
        console.log('delivered the order');
        io.emit('delivered the order');
    });

});

function chatUser(socket){
  this.socket = socket;   
}

httpsServer.listen(4007, function(){
});