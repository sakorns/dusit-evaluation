<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once('../Connections/conn.php');

$MM_authorizedUsers = "4";
$MM_donotCheckaccess = "false";

 
//print_r($_SESSION);

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../head/index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php

error_reporting( error_reporting() & ~E_NOTICE );
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_rsmember = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rsmember = $_SESSION['MM_Username'];
}
mysql_select_db($database_conn, $conn);
$query_rsmember = sprintf("
  SELECT * FROM tbl_personal as p

  INNER JOIN tbl_department as d  ON p.ref_d_id=d.d_id 
  INNER JOIN tbl_position as s   ON p.ref_po_id=s.po_id 
  

  WHERE p.p_username = %s", GetSQLValueString($colname_rsmember, "text"));
$rsmember = mysql_query($query_rsmember, $conn) or die(mysql_error());
$row_rsmember = mysql_fetch_assoc($rsmember);
$totalRows_rsmember = mysql_num_rows($rsmember);

$img=$row_rsmember['p_img'];
$ref_d_id=$row_rsmember['ref_d_id'];
$p_id = $row_rsmember['p_id'];
$c_per_id = $row_rsmember['p_id'];
$p_password = $row_rsmember['p_password'];
$pname = $row_rsmember['p_firstname'].$row_rsmember['p_name']. ' '.$row_rsmember['p_lastname'];

$name = $row_rsmember['p_name'];
$lname = $row_rsmember['p_lastname'];


//   else{
//       echo "<script type='text/javascript'>";
//       echo "window.location='index.php?p=updateimg';";
//       echo "</script>";

// }


// echo 'Wellcome '.$row_rsmember['p_name'];
// echo ' did = '.$ref_d_id;



$query_peroidassess = "SELECT * FROM tbl_date_q ORDER BY dq_id DESC";
$peroidassess = mysql_query($query_peroidassess, $conn) or die(mysql_error());
$row_peroidassess = mysql_fetch_assoc($peroidassess);
$totalRows_peroidassess = mysql_num_rows($peroidassess);
$lastterm = $row_peroidassess['dq_name'];
//echo $lastterm;
?>
 
<?php
mysql_free_result($rsmember);
?>
