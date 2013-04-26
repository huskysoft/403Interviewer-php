<?php 
include('db_credentials.php');
$sslmode = "require";
$options = "'--client_encoding=UTF8'";

$con = pg_connect("host=$host dbname=$db port=$port, user=$user password=$pass sslmode=$sslmode options=$options")
    or die('Could not connect: ' . pg_last_error());

$query = "SELECT * FROM \"JDO_QUESTIONS\""; 

$rs = pg_query($con, $query) or die("Cannot execute query: $query\n");

while ($row = pg_fetch_row($rs)) {
  echo "$row[0] $row[1] $row[2]\n";
}

pg_close($con);
?>