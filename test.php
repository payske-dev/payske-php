<?php

require_once('init.php');

// print_r( $argv);

// \Payske\Payske::setVerifySslCerts(true);
// \Payske\Payske::setCABundlePath('/Applications/XAMPP/xamppfiles/htdocs/floospay.com/flospaySDKs/Flospay_php_python_07_09_2021/Flospay.php/data/ca-certificates.crt');
// \Payske\Payske::setCABundlePath('/Applications/XAMPP/xamppfiles/htdocs/floospay.com/flospaySDKs/Flospay_php_python_07_09_2021/Flospay.php/data/cabandle.pem');
// \Payske\Payske::setCABundlePath('./data/cabandle.pem');

// $payske = new \Payske\PayskeClient('sk_test_UiiMzY3NDE3Mzg3NDc0MDIzMjQsKEq00Eq01Uii58082');
$payske = new \Payske\PayskeClient('MTQzMzQ1OTcxODU0MzY3MzYsKEq00Eq01UiisKa0A0UiiMTkwNzgwMTQ1OTM5NDcxNDksKEq00Eq01Uii56517');

if (@$argv[1] && @$argv[1]=='create') {
    $customer = $payske->customers->create([
        'email' => 'php_test@payske.com',
        'balance' => 0,
        'invoice_prefix' => '825ADB9',
        'name' => 'PHP Test Client',
        'description' => 'PHP Sample User',
        'test_exempt' => 'none'
    ]);
    echo $customer;
    
}

if (@$argv[1] && @$argv[1]=='retrieve' && @$argv[2]) {

    $customer =  $payske->customers->retrieve(@$argv[2],
        []
    );
    echo $customer;
}
if (@$argv[1] && @$argv[1]=='update' && @$argv[2]) {

    $customer =  $payske->customers->update(
        @$argv[2],
        [
            // '_method'=>'PUT',
            'metadata' => ['order_id' => '233343'],
        ]
      );
      
    echo $customer;
}

if (@$argv[1] && @$argv[1]=='all') {

    $customers =  $payske->customers->all(['limit' => @$argv[2]?@$argv[2]:3]);

    echo $customers;
}


echo \php_uname();
