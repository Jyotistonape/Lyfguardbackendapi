<?php
//echo "HELLO";
$req_dump = file_get_contents('php://input');
//print_r($req_dump);
$type='FETCH INVENTORY';
if(isset($_GET['type']))
{
$type=$_GET['type'];
}
$fp = fopen('./log/dcg_inventory.log', 'a');
fwrite($fp, $type);
fwrite($fp, $req_dump);
fclose($fp);
//echo "CLOSE";
