<?php 

return [
	'client_id' => env('PAYPAL_CLIENT_ID','AUwTnoowF_vq8hm2DY7QHf3HCJQ8RPZf3i_bZ8ibMLxMRw0Etpo0IzWtmsOgJyBbQMgmOMWJE4G8Bdoj'),
	'secret' => env('PAYPAL_SECRET',''),
	'settings' => array(
		'mode' => env('PAYPAL_MODE','sandbox'),
        'http.ConnectionTimeOut' => 30,
        'log.LogEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'ERROR'
	),
];

?>