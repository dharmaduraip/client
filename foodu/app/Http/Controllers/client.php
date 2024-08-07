

<?php
/**
 * Created by PhpStorm.
 * User: Sidson_Aidson
 * Date: 08/06/2017
 * Time: 11:27
 */

/**
 * client
 */
require_once 'SocketIO.php';

$client = new SocketIO('ssl://dev.abserve.tech', 4007);
//$client->setProtocole('ssl://');

$client->setQueryParams([
    'token' => 'edihsudshuz',
    'id' => '8780',
    'cid' => '344',
    'cmp' => 2339
]);

// $success = $client->emit('create connection','test');

// if(!$success)
// {
//     var_dump($client->getErrors());
// }
// else{
//     var_dump("Success");
// }
/*$client->on('emitting check', function($params) use($socket){
	echo "string";
})*/

/*$success = $client->emit('eventFromPhp', [
    'name' => 'Goku',
    'age' => '23',
    'address' => 'Sudbury, On, Canada'
]);

if(!$success)
{
    var_dump($client->getErrors());
}
else{
    var_dump("Success");
}*/
