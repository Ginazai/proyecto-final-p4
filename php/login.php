<?php

if(!empty($_POST)){
	if(isset($_POST["username"]) &&isset($_POST["password"])){
		if($_POST["username"]!=""&&$_POST["password"]!=""){
			try {
				include "conexion.php";
			
				$user_id=null;
				$user_role=array();
				$sql1= "select * from user, roles where (username=\"$_POST[username]\" or email=\"$_POST[username]\") and password=\"$_POST[password]\" ";
				$query = $con->query($sql1);
				while ($r=$query->fetch_array()) {
					$user_id=$r["id"];

					$sql2= "select * from user_roles where (user_id=$user_id)";	
					$query = $con->query($sql2);
						while ($r2=$query->fetch_array()){
							array_push($user_role, $r2['role_id']);
							break;
						}
					break;
				}
				if($user_id==null){
					print "<script>alert(\"Acceso invalido.\");window.location='../login.php';</script>";
				} else{
					session_start();
					$_SESSION["user_id"]=$user_id;
					$_SESSION['role']=$user_role;
					print "<script>window.location='../home.php';</script>";				
				}
			}
			catch (Exception $e) {
				$e->getMessage();
				echo($e->getMessage());
			}
		}
	}
}



?>