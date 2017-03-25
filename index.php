<?php
require_once("Settings/Koneksi.php");
require_once("Settings/Crud.php");

use Settings\Koneksi;
use Settings\Crud;

$db = new Crud();

//$db->insert('tesajah(nama,kelas,npm)',[['azurescarlet','02','1531555']])->execute();

print_r($db->select('*')->from('tesajah')->where([['aa ='=>'gg'],['ss ='=>'hh'],['gg >'=>'jj']])->execute());

 ?>
