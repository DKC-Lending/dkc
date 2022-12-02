<?php
include 'investment_connect.php';
include '../notification/notificationHandler.php';


error_reporting(1);
class Posts{
	function latest_post_date($i_conn){
		$sql = "SELECT pdate FROM posts ORDER BY pid DESC";
		$rslt = mysqli_query($i_conn,$sql);
		$datas = mysqli_fetch_array($rslt);
		
		return $datas;

	}
	function get_posts_from_pid($i_conn,$pid){
		
		$sql = "SELECT * FROM posts WHERE pid='$pid'";
		$rslt = mysqli_query($i_conn,$sql);
		$datas = mysqli_fetch_array($rslt);
			
		return $datas;
}
	function get_posts($i_conn){
			$result=[];
			$sql = "SELECT * FROM posts ORDER BY pid DESC";
			$rslt = mysqli_query($i_conn,$sql);
			while($datas = mysqli_fetch_array($rslt)){
				array_push($result,$datas);
			}
			return $result;
	}

	function get_total_user_interest_post($i_conn,$user){
		$result=0;
			$pids=[];
			$sql = "SELECT pid FROM posts ORDER BY pid DESC";
			$rslt = mysqli_query($i_conn,$sql);
			while($datas = mysqli_fetch_array($rslt)){
				$pid = $datas["pid"];				
				array_push($pids,$pid);
			}
			foreach($pids as $pid){
				$in_sql = "SELECT * FROM p$pid";
				$in_rslt = mysqli_query($i_conn,$in_sql);
				$in_datas_temp = mysqli_fetch_array($in_rslt);		
				if (!empty($in_datas_temp)){
				$in_rslt = mysqli_query($i_conn,$in_sql);
				while($in_datas = mysqli_fetch_array($in_rslt)){
						if($user==$in_datas["username"]){
						
								$result+=1;
						}
					}
				}
			}

			return $result;
	}
	function sold_post($pid,$i_conn){
		$tsql = "SELECT status FROM posts WHERE pid='$pid'";
		$query = mysqli_query($i_conn,$tsql);
		while($row = mysqli_fetch_assoc($query)) {
			$st= $row["status"]=="0"?"1":"0";
		}
		
		$sql = "UPDATE posts SET status='$st' WHERE pid='$pid'";
		mysqli_query($i_conn,$sql);
		
	}


	function delete_post($pid,$i_conn){
		
		$sql = "DELETE FROM posts WHERE pid='$pid'";
		mysqli_query($i_conn,$sql);
		$dropsql = "DROP TABLE p$pid";
		$i_conn->query($dropsql);
	}

	function get_interested_user($i_conn,$user){
			$result=[];
			$pids=[];
			$sql = "SELECT pid FROM posts ORDER BY pid DESC";
			$rslt = mysqli_query($i_conn,$sql);
			while($datas = mysqli_fetch_array($rslt)){
				$pid = $datas["pid"];				
				array_push($pids,$pid);
			}
			foreach($pids as $pid){
				$in_sql = "SELECT * FROM p$pid";
				$in_rslt = mysqli_query($i_conn,$in_sql);
				$in_datas_temp = mysqli_fetch_array($in_rslt);		
				if (!empty($in_datas_temp)){
				$in_rslt = mysqli_query($i_conn,$in_sql);
				while($in_datas = mysqli_fetch_array($in_rslt)){
						if($user==$in_datas["username"]){
						
								array_push($result,$in_datas["offer"]);
						}else{
							
								array_push($result,5);
						}
					}
				}else{
							
					array_push($result,5);
			}
			}

			return $result;
	}

	function add_user_offer($i_conn,$pid,$user,$link,$offer){
		include '../usercontrol.php';
		$detail = $Users->get_details_from_username($conn,$user);
		$sql = "INSERT INTO p$pid (username,offer) VALUES ('$user', '$offer')";
				mysqli_query($i_conn,$sql);
		$pdate = (string)date("d/m/Y");
		$noti = new Notification();
		$ioff = $offer==0?"50%":($offer==1?"75%":"99%");
		$noti = $noti->addNotification($user,$pid, $pdate, $ioff,'New Investment Opportunity', $i_conn );
		$ioff = $offer==0?"50%":($offer==1?"75%":"99%");
		include('../../library/smtp/PHPMailerAutoload.php');
		include '../message/email.php';
		$phone = $detail['phone'];
		$email = $detail['email'];
		$html = "<p>Hi David,<br>".
		"$user is interested in investing opportunity.".
		"<br></p>".
		"Here are the details: ".
		"".
		"<br>".
		"<b>Interested in $ioff of :</b> <a href='$link'>$link</a>".
		"<br>".
		"<b>Username :</b> $user".
		"<br>".
		"<b>Contact :</b> $phone".
		"<br>".
		"<b>Email :</b> $email".
		"<br>".
		"<p>Thank You!</p>";
		send_email('webmaster@dkclending.com',$html,"$user is intrested in Investment Opportunity");



		// $in_sql = "SELECT $offer FROM p$pid";
		// $in_rslt = mysqli_query($i_conn,$in_sql);
		// while($in_datas = mysqli_fetch_array($in_rslt,MYSQLI_ASSOC)){
		// 	if($user==$in_datas["username"]){
		// 		$sql = "UPDATE p$pid SET offer='$offer' WHERE username='$user'";
		// 		mysqli_query($i_conn,$sql);
		// 		break;
		// 	}else{
		// 		$sql = "INSERT INTO p$pid (username,offer) VALUES ('$user', '$offer')";
		// 		mysqli_query($i_conn,$sql);
		// 		break;
		// 	}
		// 	}
	
	}

	function remove_user_offer($i_conn,$pid,$user){
		$sql = "DELETE FROM p$pid WHERE username='$user'";
		mysqli_query($i_conn,$sql);
	}
}

$posts =new Posts();

if(isset($_POST["delfunc"])){
	
	
	$pid = $_POST['pid'];
	
	$posts->delete_post($pid,$i_conn);
}


if(isset($_POST["soldFunc"])){
	
	
	$pid = $_POST['pid'];
	
	$posts->sold_post($pid,$i_conn);
}

if(isset($_POST["addoff"])){
	
	$pid = $_POST['pid'];
	$user = $_POST['user'];
	$offer = $_POST['offer'];
	$plink = $_POST['link'];
	unset($_POST["addoff"]);
	$posts->add_user_offer($i_conn,$pid,$user,$plink,$offer);
}

if(isset($_POST["deloffer"])){
	$pid = $_POST['tpid'];
	$uname = $_POST['user'];
	unset($_POST["deloffer"]);
	
	$posts->remove_user_offer($i_conn,$pid,$uname);
}
?>