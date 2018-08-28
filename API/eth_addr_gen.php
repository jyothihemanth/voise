<?php 
$cmd = "cd  /var/www/html/voise/nodejs_web3_10/; node create_acc.js";
    $output = shell_exec($cmd);
    $acc = json_decode($output,true); 
    $eth_wallet = $acc['address'];
    $eth_pk = $acc['privateKey'];
    $eth_pk = substr($eth_pk, 2);

     echo $eth_wallet;

?>
