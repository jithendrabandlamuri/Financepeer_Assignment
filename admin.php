<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
<head>
<title> Shuttle: Travel along! </title>
<meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>
.detail
{
	height:500px;
}

#pholder {
	max-height: 100px;
	max-width: 100px;
}

.center {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 50%;
}

.wrapper {
	text-align: center;
}

#info {

}

#footer {
  background-color: #e3f2fd;
   height: 50px;
    font-family: 'Verdana', sans-serif;
    padding: 20px;
}
</style>
</head>
<body style="background-color: powderblue;">
<!--header-->
  <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
    <div class="container-fluid">
      <div class= "navbar-header">
        <button type= "button" class="navbar-toggle" data-toggle= "collapse" data-target= "#bs-shuttle-navbar-collapse-1">
          <span class= "sr-only"> Toggle navigation </span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
         </button>
      <a class="navbar-brand" href="./homepage.php"> FINANCEPEER </a> 
    </div>
  <div class= "collapse navbar-collapse navbar-right" id="bs-shuttle-navbar-collapse-1">
    <ul class= "nav navbar-nav">
       <ul class= "nav navbar-nav">

      <li> <a href="./homepage.php"> Logout </a> </li>
      
    </ul>
    </ul>
    </div>  
  </div>
</nav>

<div class= "container-fluid">
 <div class= "col-md-4" >
  <div class= "panel panel-info" id="info" >
      <div class= "panel-heading">
        <h4 class= "panel-title" align="center"> Your Information </h4>
      </div> 

<?php 

$server="localhost";
$username="root";
$password="";
$db="financepeer";
$t= $_SESSION['logged_user'];
$conn = new mysqli($server,$username,$password,$db);
if($conn->connect_error){
    die("Connection failed".mysqli_connect_error());
}
  $result= $conn->query ("SELECT * FROM customer where cid = '$t'");
  $row = $result->fetch_assoc();

  $n = $row['name'];
  $e = $row['email'];
  $g = $row['type'];



if(isset($_POST['buttonImport'])){
  copy($_FILES['jsonFile']['tmp_name'], 'jsonFiles/'.$_FILES['jsonFile']['name']);
  $data = file_get_contents('jsonFiles/'.$_FILES['jsonFile']['name']);
  $products = json_decode($data,true);
  foreach ($products as $row){
    $sql = "INSERT INTO `data` (`userId`,`id`,`title`,`body`) VALUES ('".$row["userId"]."','".$row["id"]."','".$row["title"]."','".$row["body"]."') ";
    mysqli_query($conn,$sql);
  }
  echo '<script>alert("Data Inserted Successfully")</script>';
}


?>

<div class= "panel panel-body detail">
      <img id="pholder" class= "center" src="./images/placeholder.png">
      <br>
      <br>
      <table class = "table">
      <tr>
         <td align="center">Name: <?php echo "$n"; ?></td>
      </tr>
      
      <tr>
         <td align="center">E-mail: <?php echo "$e"; ?></td>
      </tr>
            <tr>
         <td align="center">Type: <?php echo "$g";?></td>
      </tr>
   </table>
   <br>
   <br>
   <form method="post" enctype="multipart/form-data">
     <label for="file" style="margin-left:150px">File:</label>
    <input type="file" name="jsonFile" id= "file" placeholder="Select File" style="float: right;margin-right:30px" accept=".json">
    <br><br>
   <center><input type="submit" value="Import" name="buttonImport" ></center>
   </form>
   
      </div>
    </div>
</div>

<div class="col-md-8">
  <div class="panel panel-success">
    <div class="panel-heading" align="center"><b>Dashboard</b></div>
    <div class="panel-body log">

    <table style="border: 1px solid black;width: 100%;">
  <tr>
    <th style="border: 1px solid black;text-align: center;">USERID</th>
    <th style="border: 1px solid black;text-align: center;">ID</th>
    <th style="border: 1px solid black;text-align: center;">TITLE</th>
    <th style="border: 1px solid black;text-align: center;">BODY</th>
  </tr>
  <?php
      $selectquery = "select * from data";
      $query=mysqli_query($conn,$selectquery);
      $nums=mysqli_num_rows($query);
      while($res = mysqli_fetch_array($query)){

        
      
      ?>
  <tr>
    <td style="border: 1px solid black;"><?php echo $res['userId']; ?></td>
    <td style="border: 1px solid black;"><?php echo $res['id']; ?></td>
    <td style="border: 1px solid black;"><?php echo $res['title']; ?></td>
    <td style="border: 1px solid black;"><?php echo $res['body']; ?></td>
  </tr>
  <?php 
        }
        ?>
</table>
      
    </div>
  </div>
</div>
</div>

</body>
</html>




