<?php 

$id = $_GET['uneVisio'];
$getAvis = $pdo->getAvisFromOneVisio($id);
foreach ($getAvis as $unAvis)
{
    echo $unAvis['textAvis'];
    echo '<br/>';
}