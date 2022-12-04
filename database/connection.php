<?php
  $host = "localhost";
  $username = "root";
  $password = "";
  $database = "dams_db";

  $con = new mysqli($host, $username, $password, $database);
  if($con->connect_error){
      return $con->connect_error;
  }
  else{
      return $con;
  }
  

