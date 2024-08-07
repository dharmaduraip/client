var FCM = require('fcm-node');
    var serverKey = 'AAAAuO81O_k:APA91bG_RHL_gluzc-19OoJMEuRKj-rhPowcSFhNwnTCwE5PgeiM85Aq-ieXjDGenel48lt-Crjxym3SCTv8dW8myxtGC-3iF6GvwkdNrpun2cw4zJSFzZ-cwXSN0TInoYZ7HD12Rf9A'; //put your server key here
    var fcm = new FCM(serverKey);
     var schedule = require('node-schedule');
    var message = { //this may vary according to the message type (single recipient, multicast, topic, et cetera)
        to: 'fnR4CQW_Kig:APA91bEq2YKVZHs005jWNt84SsIfdiBn6yBpKMUsw9KYBjgU-OzKuKa9t27IuIhSKB-icBWhNYyJzMmzCcG39IAbWEPKVKseGWoG4np_A03JPu7YefUCA7YcrFCqc2Cjk-Ycl6bFjY2p', 
        collapse_key: 'green',
        priority: "high",
        data: {  //you can send only notification or only data(or include both)
            message: 'New Incoming',
            title: 'dummy', 	
            image: "https://cdn.vox-cdn.com/uploads/chorus_image/image/50319963/whopperito.0.0.jpg"
             //default notification icon
        }
    };
     var rule = new schedule.RecurrenceRule();
     rule.minute = new schedule.Range(0, 59, 1);
     var j = schedule.scheduleJob(rule, function(){
     	 fcm.send(message, function(err, response){
        if (err) {
            console.log("Something has gone wrong!",err);
        } else {
            console.log("Successfully sent with response: ", response);
        }
    });
     });
      fcm.send(message, function(err, response){
        if (err) {
            console.log("Something has gone wrong!",err);
        } else {
            console.log("Successfully sent with response: ", response);
        }
    });