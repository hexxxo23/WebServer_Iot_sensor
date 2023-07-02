<?php

$host = "194.163.42.201";
$user ="filt9288_pramono";
$pass = "Luthfisangaji2301";
$database = "filt9288_filtrasi-database";

// $host = "localhost";
// $user ="root";
// $pass = "";
// $database = "skripsi";

$con = mysqli_connect($host,$user,$pass,$database);

if (! $con){
    die("Connected Failed: ".mysqli_connect_error());
}
echo "Database Connected <br>";
$tds = (int)$_GET["tds"];
$ph = (float)$_GET["ph"];
$turbidity =(int)$_GET["turbidity"];
$temp = (float)$_GET["temp"];
// $date = date('Y-m-d');
// TDS:
// - Very Good: <200ppm
// - Good: 201-600ppm
// - Bad: 601-1400ppm
// - Very Bad: 1401-1500ppm
// - Warning: >1500ppm

// Turbidity:
// - Very Good: <15NTU
// - Good: 35-60
// - Bad: 61-100NTU
// - Very Bad: 100-250
// - Warning: >101

// pH:
// - Very Good: 7pH
// - Good: 6-6.9pH atau 7.1-8pH
// - Bad: 5-5.9pH atau 8.1-9pH
// - Very Bad:  4-4.9pH atau 10-10.9pH
// - Warning: < 4pH atau >= 11pH

// Suhu:
// - Very Good: 18-25 C
// - Good: 26-29 C
// - Bad: 30-35 C
// - Very Bad: 36-40 C
// - Warning: >40 C

// $tds = 29;
// $ph = 7.2;
// $turbidity = 20;
// $temp = 26;
$date = date('Y-m-d');
$stat='';
$flag = 0;

if ($tds<=20 && $turbidity<=15 && $ph == 7.0 ){
    $stat = 'VERY GOOD';    
    $flag = 0;
}
else if ((20<$tds && $tds <=400) && (15<$turbidity && $turbidity<=35 ) && ((6.0<$ph && $ph <= 6.9) ||((7.1<=$ph && $ph < 8.0))) ){
    $stat = 'GOOD'; 
    $flag = 0;   
}
else if ((400<$tds && $tds <=600) && (35<$turbidity && $turbidity<=60 ) && ((5.0<$ph && $ph <= 5.9) ||((8.0<=$ph && $ph < 10.0))) ){
    $stat = 'BAD';  
    $flag = 1;  
    
}
else if ((600<$tds && $tds <=1400) && (60<$turbidity && $turbidity<=100 ) && ((4.0<$ph && $ph <= 4.9) ||((10.0<=$ph && $ph < 11))) ){
    $stat = 'VERY BAD'; 
    $flag = 1;    
}
else if ( $tds >1400 && $turbidity>100 && ($ph <= 4.0 ||  $ph >= 11 ) ){
    $stat = 'WARNING'; 
    $flag = 1;    
}

if ($ph>7.00){
    $temp =$temp+2;
}
else if ($ph>7.00){
    $temp =$temp-3;
}
// var_dump($stat) ;




// echo $tds;
if($tds != null && $turbidity!=null && $stat !=''){
    $sql = "INSERT INTO FILTRATION (DATE, TOTAL_DISSOLVE_SOLID	,ACIDITY,TURBIDITY,TEMPERATURE,STATUS,FLAG) VALUES ( '$date',$tds,$ph,$turbidity,$temp,'$stat',$flag)";
    // $sql = "INSERT INTO arduino_data_value (adv_tds, adv_ph,adv_turbidity,adv_temperature,adv_date_time,adv_status) VALUES ($tds,$ph,$turbidity,$temp,'$date','$stat')";
    echo $sql;
    $input = mysqli_query($con,$sql);
    if($input == TRUE){
        echo "Berhasil Input Data";
    }else{
        echo "Fail";
    }
}else{
    echo "Empty Data";
}


// if(isset($_POST["tds"]) && isset($_POST["ph"])&& isset($_POST["turbidity"])&& isset($_POST["temp"])  ){
//     $tds = $_POST["tds"];
//     $ph = $_POST["ph"];
//     $turbidity =$_POST["turbidity"];
//     $temp = $_POST["temp"];


//     $sql = "INSERT INTO arduino_data_value (adv_tds, adv_ph,adv_turbidity,adv_temperature,adv_date_time) VALUES (".$tds.",".$ph.",".$turbidity.",".$temp.",now())";
//     if(mysqli_query($con,$sql)){
//         echo " Data added";
//     } else{
//         echo "error".$sql."<br>".mysqli_error($con);
//     }
// }

?>