<?php
$db = mysqli_connect('localhost','root','','NitPick_db') or die(mysqli_connect_error());
mysqli_set_charset($db,'utf8');

//mysqli_connect('localhost','root','','protama_db')
//『protama_db』の部分を、Nit Pick用のDBの名前に変える

//mysqli_set_charset($db,'utf8');
//→DB内での文字化け回避
