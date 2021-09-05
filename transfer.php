<?php
session_start();
$server="localhost";
$username="root";
$password="";
$con=mysqli_connect($server,$username,$password,"bank1");
if(!$con){
    die("Connection failed");
} 


$flag=false;

if (isset($_POST['transfer']))
{
$sender=$_SESSION['sender'];
$receiver=$_POST["reciever"];
$amount=$_POST["amount"];}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Online Bank Serivice</title>
<meta name="viewport" content="width=device-width, initial-scale=1"> <style>
.button {
            background-color: #2b67f8;
            border-radius: 29px;
            border-bottom-color: red;
            color: white;
            padding: 10px 25px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 20px;
        }
        
        .button:hover {
            background-color: #1844aa
        }
        
        .button:active {
            background-color: #1844aa;
            box-shadow: 0 5px #666;
            transform: translateY(4px);
        }
        .header {
            margin-left: 10px;
            color: #243e83;
            font-size: 61px;
            font-variant: small-caps;
            margin-top: -5%;
            margin-bottom: -5%;
            
        }
        .topnav {
            overflow: hidden;
            background-color: rgb(122, 180, 235);
            
        }

</style>
<div class="topnav"><div class="header">
        <h5 style="padding-right: 1rem">Online Bank Service</h5>
        
 </div>
        
    </div>


   



<?php

$sql = "SELECT Balance FROM detail WHERE name='$sender'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
 if($amount>$row["Balance"] or $row["Balance"]-$amount<100){
  echo'<br><br><br><br><br><br>';
    echo '<center><h1>Transaction Denied, Insufficient balance</h1></center>';
   
 }
else{
    $sql = "UPDATE `detail` SET Balance=(Balance-$amount) WHERE Name='$sender'";
    

if ($con->query($sql) === TRUE) {
  $flag=true;
} else {
  echo "Error in updating record: " . $conn->error;
}
 }
 
  }
} else {
  echo "0 results";
} 

if($flag==true){
$sql = "UPDATE `detail` SET Balance=(Balance+$amount) WHERE name='$receiver'";

if ($con->query($sql) === TRUE) {
  $flag=true;  
  
} else {
  echo "Error in updating record: " . $con->error;
}
}
if($flag==true){
    $sql = "SELECT * from detail where name='$sender'";
    $result = $con-> query($sql);
    while($row = $result->fetch_assoc())
     {
         $s_acc=$row['id'];
 }
 $sql = "SELECT * from detail where name='$receiver'";
 $result = $con-> query($sql);
while($row = $result->fetch_assoc())
  {
      $r_acc=$row['id'];
}        
$sql = "INSERT INTO `transfer`(s_name,r_name,amount) VALUES ('$sender','$receiver','$amount')";
if ($con->query($sql) === TRUE) {
} else 
{
  echo "Error updating record: " . $con->error;
}
}

if($flag==true){
  echo'<br><br><br><br><br><br>';
echo '<center><h1>Money sent, Your transaction was successful</h1></center>';

}
elseif($flag==false)
{
    echo "<script>
        $('#text2').show()
     </script>";
}
?>

    <center><a href= "transc.php"> <button class="button">  View Transaction Here </button></a></center>
    <script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>


</head>

</html>
