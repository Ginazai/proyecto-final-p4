<?php

if(!empty($_POST)){
	if(isset($_POST["username"]) &&isset($_POST["password"])){
		if($_POST["username"]!=""&&$_POST["password"]!=""){
			try {
				include "conexion.php";
			
				$user_id=null;
				$user_role=array();
				$sql1= "select * from user where (username=\"$_POST[username]\" or email=\"$_POST[username]\") and password=\"$_POST[password]\" ";
				$query = $con->query($sql1);
				while ($r=$query->fetch_array()) {
					$user_id=$r["id"];
					$user_name=$r["fullname"];

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
					$_SESSION['user_name']=$user_name;
					/**
					 * Session table control
					 * */
					$config = include 'config.php';
					$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
    				$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
    				/**
    				 * Verifies if there's an existing relation (prevent redundancy)
    				 * */
					$session_query = $conexion->prepare("INSERT IGNORE INTO session (user_id, is_active, last_activity) 
						VALUES (:uid, :active, :lactivity)");
					$session_query->execute(array(
						':uid' => $user_id,
						':active' => 1,
						':lactivity' => date("Y-m-d H:i:s")
					));
					/**
					 * Proceed to insertion if the relation doesn't exists*/
					if($session_query->fetchAll() > 0){
						$session_update = $conexion->prepare('UPDATE session SET is_active = :active, last_activity = :lactivity 
							WHERE user_id = :uid');
						$session_update->execute([
							':uid' => $user_id,
							':active' => 1,
							':lactivity' => date("Y-m-d H:i:s")
						]);
					}

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