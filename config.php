<?php
   /*define('DB_SERVER', 'localhost:3306');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '');
   define('DB_DATABASE', 'db_sih3');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   if (! $db) {
      echo "Failed Connection !";
   }*/
   date_default_timezone_set("Asia/Jakarta");
   error_reporting(0);

	// sesuaikan dengan server anda
	$host 	= 'localhost:8889'; // host server
	$user 	= 'root';  // username server
	$pass 	= 'root'; // password server, kalau pakai xampp kosongin saja
	$dbname = 'db_sitangkal'; // nama database anda
	
	try{
		$config = new PDO("mysql:host=$host;dbname=$dbname;", $user,$pass);
		//echo 'sukses';
	}catch(PDOException $e){
		echo 'KONEKSI GAGAL ' .$e -> getMessage();
	}
?>
