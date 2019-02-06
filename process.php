<?php
session_start();
include_once ("connect_db.php");

//lang
if($_COOKIE['language'] == "srb"){
    define("access", 1); 
	
   include("languages/lang.srb.php");
} else if($_COOKIE['language'] == "en"){
   define("access", 1);


   include("languages/lang.en.php");
} 

if($_COOKIE['language'] == ""){
    define("access", 1); 
	
   include("languages/lang.srb.php");
}

if (isset($_GET['task']) && $_GET['task'] == "register") {
	$username = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['username'])));
	$password = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['password'])));
	$password2 = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['password2'])));
	$email = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['email'])));
	$ime = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['ime'])));
	$prezime = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['prezime'])));
	$ip_adresa = $_SERVER['REMOTE_ADDR'];
    
	if (!ctype_alnum($username)) { 
	    $_SESSION['error'] = "$lang[p_register1]";
		header("Location:/register");
        die();
	}
	
        if(strlen($username) > 20 || strlen($username) < 4){
        $_SESSION['error'] = "$lang[p_register2]";
		header("Location:/register");
        die();
        }
 
	$kveri = mysql_query("SELECT * FROM users WHERE username='$username'");
	if (mysql_num_rows($kveri)>0) {
	    $_SESSION['error'] = "$lang[p_register3]";
		header("Location:/register");
		die();
	}
	$kveri = mysql_query("SELECT * FROM users WHERE email='$email'");
	if (mysql_num_rows($kveri)>0) {
		$_SESSION['error'] = "$lang[p_register4]";
		header("Location:/register");
		die();
	}
	
	if ($password == $password2) {	
		$cpass = md5($password);
		$time = date("d.m.Y h:m");
		$sql = "INSERT INTO users (username,ime,prezime,password,email,register_time,ip) VALUES ('$username','$ime','$prezime','$cpass','$email','$time','$ip_adresa')";
		//echo $sql;
		mysql_query($sql);	
		$_SESSION['ok'] = "$lang[p_register5]";
		header("location:/index.php");
	} else {
		$_SESSION['error'] = "$lang[p_register6]";
		header("Location:/register");
		die();
	}
} else if (isset($_GET['task']) && $_GET['task'] == "login") {
	$username = htmlentities(addslashes($_POST['username']));
	$password = htmlentities(addslashes($_POST['password']));
	$cpass = md5($password);
	$ip_adresa = $_SERVER['REMOTE_ADDR'];
	
	$kveri = mysql_query("SELECT * FROM users WHERE username='$username' AND password='$cpass'");
	if (mysql_num_rows($kveri)) {
		$user = mysql_fetch_array($kveri);
		$_SESSION['userid'] = $user['userid'];
		$_SESSION['username'] = $user['username'];
		$mesec = 24*60*60*31; // mesec dana
		
		$sesija = md5($user['username'] . $cpass);
		
        if (isset($_POST['remember'])) {
            /* Set cookie to last 1 year */
            setcookie('username', $_POST['username'], time()+ $mesec);
            setcookie('password', md5($_POST['password']), time()+ $mesec);
        } else {
            /* Cookie expires when browser closes */
            setcookie('username', $_POST['username'], false);
            setcookie('password', md5($_POST['password']), false);
        }
		
		setcookie("userid", $user['userid'], time()+ $mesec);
		setcookie("username", $user['username'], time()+ $mesec);
		setcookie("sesija", $sesija, time() + $mesec);
		$_SESSION['ok'] = "$lang[p_login1]";
		mysql_query("UPDATE users SET ip='$ip_adresa',sesija='$sesija' WHERE userid='$_SESSION[userid]'");
		header("Location:/index.php");
	} else {
		$_SESSION['error'] = "$lang[p_login2]";
		header("location:/login");
		die();
	}
} else if (isset($_GET['task']) && $_GET['task'] == "reset_password") {
  
    $email = htmlspecialchars(mysql_real_escape_string($_POST['email']));
	
	$email_check = mysql_query("SELECT * FROM users WHERE email='".$email."'");
	$count = mysql_num_rows($email_check);
	
	if ($count != 0) {
	$random = uniqid();
	$new_password = $random;
	
	$email_password = $new_password;
	
	$new_password = md5($new_password);
	
	mysql_query("update users set password='".$new_password."' WHERE email='".$email."'");
	
	$subject = "$lang[p_resetp1]";
	$message = "$lang[p_resetp2] $email, 
	
	$lang[p_resetp3] $email_password
	
	$lang[p_resetp4] : www.mygame.rs/login
	
	
	MyGame.RS $lang[p_resetp5]";
	$from = "From: morphe_uS@live.com";
	
	mail($email, $subject, $message, $from);
	$_SESSION['ok'] = "$lang[p_resetp6] na <b> ".$email." </b> ";
	header("location:index.php");
	}
	else {
	$_SESSION['error'] = "$lang[p_resetp7]";
	header("location:/login");
	}
	
} else if (isset($_GET['task']) && $_GET['task'] == "add_server") {
  $game = $_POST['game'];
  $location = $_POST['location'];
  $mod = $_POST['mod'];
  $ip = htmlspecialchars(addslashes($_POST['ip']));
  $time = time();
  
  // modovi
  if($game == "cs16"){
	  $mods = array(
						'Public'				=> 'PUB',
						'Deathmatch'			=> 'DM',
						'Deathrun'				=> 'DR',
						'Gungame'				=> 'GG',
						'KreedZ'				=> 'KZ',
						'HideNSeek'				=> 'HNS',
						'Soccer Jam'			=> 'SJ',
						'Knife Arena'			=> 'KA',
						'Zombie'                => 'ZM',
						'Super Hero'			=> 'SH',
						'Surf'					=> 'SURF',
						'Warcraft3'             => 'WC3',
						'PaintBall'				=> 'PB',
						'Zmurka'				=> 'ZMRK',
						'Capture The Flag'		=> 'CTF',
						'ClanWar'               => 'CW',
						'Ostalo'                => 'OSTALO',
						'AWP'                   => 'AWP',
						'de_dust2 only'			=> 'DD2',
						'Fun, Fy, Aim'			=> 'FUN',
						'CoD'			      	=> 'COD',
						'BaseBuilder'		    => 'BB',
						'JailBreak'             => 'JB',
						'Battlefield2'          => 'BF2',
						);
  } else if($game == "css"){
	  $mods = array(
						'Public'				=> 'PUB',
						'Deathmatch'			=> 'DM',
						'Deathrun'				=> 'DR',
						'Gungame'				=> 'GG',	
                        'Zombie'                => 'ZM',
						'ClanWar'               => 'CW',
	  );
  } else if($game == "cod2"){
      $mods = array(
						'Pam Mod'				=> 'PAM',
						'Promod 4'			    => 'PM4',
						'Additional War Effects'=> 'AWE',
	  );	  
  } else if($game == "cod4"){
      $mods = array(
						'Pam Mod'				=> 'PAM',
						'Promod 4'			    => 'PM4',
						'Balkan Special Forces' => 'BSF',
						'Promodlive204'         => 'PROMODLIVE204',
						'Extreme 2.6'           => 'EXTREME2.6',
						'Reign of the undeath'  => 'ROTU',
	  );	      
  } else if($game == "samp" OR $game == "minecraft" OR $game == "teamspeak3" OR $game == "tf2" OR $game == "csgo"){
	 $mods = array(
						'DEFAULT'				=> 'DEFAULT',
	  );	    
  }
  // kraj
  
  if(mysql_num_rows(mysql_query("SELECT id FROM servers WHERE ip='$ip'"))>0){
  $_SESSION['error'] = "$lang[p_add1]";
  header("location:/server_info/$ip");
  die();
  }
  
  if(mysql_num_rows(mysql_query("SELECT ip FROM b_servers WHERE ip='$ip' AND type='1'"))>0){
  $_SESSION['error'] = "$lang[p_server_banovan]";
  header("location:/dodaj");
  die();
  }
  
  if($game == "minecraft" OR $game == "cs16" OR $game == "css" OR $game == "csgo" OR $game == "cod2" OR $game == "tf2"){
  $skrati_ip = substr($ip, 0, -6);
  } else if($game == "samp" OR $game == "teamspeak3" OR $game == "cod4"){  
  $skrati_ip = substr($ip, 0, -5);
  }
  
  if(mysql_num_rows(mysql_query("SELECT ip FROM b_servers WHERE ip='$skrati_ip' AND type='2'"))>0){
  $_SESSION['error'] = "$lang[p_masina_banovana]";
  header("location:/dodaj");
  die();
  }
  
  if(!$ip){
		$_SESSION['error'] = "$lang[p_add2]";
		header("location:/dodaj");
		die();
  }  
  
  if ( in_array ( $mod , $mods ) ) {
  
  if($game == "cs16" OR $game == "css" OR $game == "csgo" OR $game == "cod2" OR $game == "cod4" OR $game == "tf2"){
	  $playercount = "00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00";
	  $playercount_6h = "00,00,00,00,00,00";
	  $playercount_hour = "00,00,00,00,00,00,00,00,00,00,00,00";
	  $playercount_week = "00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00";
	  $playercount_month = "00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00,00";
  } else if($game == "minecraft" OR $game == "samp" OR $game == "teamspeak3"){
	  $playercount = "0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000";
	  $playercount_6h = "0000,0000,0000,0000,0000,0000";
	  $playercount_hour = "0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000";
	  $playercount_week = "0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000";
  	  $playercount_month = "0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000";
  }
  
  $server_id = mysql_insert_id();
  
require 'GameQ.php';
$servers = array(
	array(
		'id' => $server_id,
		'type' => $game,
		'host' => $ip,
	)
);
$gq = new GameQ();
$gq->addServers($servers);
$gq->setOption('timeout', 4); // Seconds
$gq->setFilter('normalise');
$results = $gq->requestData();

foreach($results as $data){
	$type = $data['gq_type'];
	$online = $data['gq_online'];
	
  if($type == "$game" && $online == "1"){
    mysql_query("INSERT INTO servers (game,location,gamemod,ip,added,addedid,forum,playercount,playercount_6h,playercount_hour,playercount_week,playercount_month) VALUES ('$game','$location','$mod','$ip','$_COOKIE[username]','$_COOKIE[userid]','Nema','$playercount','$playercount_6h','$playercount_hour','$playercount_week','$playercount_month')");
	$_SESSION['ok'] = "$lang[p_add3]";
	header("location:/servers/");
  } else {
    $_SESSION['error'] = "$lang[p_add4] $game $lang[p_add5]";
	header("location:/dodaj");
	die();
  }
  
}

  } else {
	  $_SESSION['error'] = "$lang[p_add6] $game";
	  header("location:/dodaj");
	  die();
  }
  
} else if (isset($_GET['task']) && $_GET['task'] == "lang") {
  
   $lang = addslashes(htmlspecialchars(mysql_real_escape_string($_GET['lang'])));
   
   $mesec = 24*60*60*31; // mesec dana
   
   if($lang == "srb" OR $lang == "en"){
            setcookie("language", $lang, time()+ $mesec);
            header("location:/index.php");
			$_SESSION['ok'] = "Updated: $lang";
   } else {
		$_SESSION['error'] = "Error";
		header("location:/index.php");
		die();          
   }
 
} else if (isset($_GET['task']) && $_GET['task'] == "search_s") {
    $hostname = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['hostname'])));
	$ip = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['ip'])));
	$game = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['game'])));
	$location = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['location'])));
	$mod = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['mod'])));
	
	header("location:/servers/&hostname=$hostname&ip=$ip&game=$game&location=$location&mod=$mod");
} else if (isset($_GET['task']) && $_GET['task'] == "m_search") {
    $hostname = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['hostname'])));
	$ip = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['ip'])));
	$game = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['game'])));
	$location = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['location'])));
	$mod = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['mod'])));
	
	header("location:/m/servers/&hostname=$hostname&ip=$ip&game=$game&location=$location&mod=$mod");
} else if (isset($_GET['task']) && $_GET['task'] == "search_c") {
    $name = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['name'])));
	
	header("location:/?page=communities&name=$name");
} else if (isset($_GET['task']) && $_GET['task'] == "search_u") {
    $name = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['name'])));
	
	header("location:/?page=memberlist&name=$name");
} else if(isset($_GET['task']) && $_GET['task'] == "shoutbox_s") {
	$id = addslashes($_POST['id']);
	$message = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['message'])));
	$author = $_COOKIE['username'];
	$authorid = $_COOKIE['userid'];
	$time = time();
	
	$info = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$id'"));
	
	if($info['id'] == ""){
		$_SESSION['error'] = "$lang[servernepostoji]";
		header("location:/servers/");
		die();
	}
	
	if($author == "" OR $authorid == ""){
		$_SESSION['error'] = "$lang[prijavitese]";
		header("location:/login");
		die();
	}
	
	if(empty($message)){
		$_SESSION['error'] = "$lang[prazno]";
		header("location:/server_info/$info[ip]");
		die();
	} else {
		mysql_query("INSERT INTO shoutbox_s (sid,message,time,authorid,author) VALUES ('$id','$message','$time','$authorid','$author')");
		if($info['ownerid'] == $_COOKIE['userid']){} else {
          mysql_query("INSERT INTO obavestenja (var,nza,nod,time,status,type) VALUES ('$info[id]','$info[ownerid]','$_COOKIE[userid]','$time','0','1')") or die(mysql_error());
        }
		mysql_query("INSERT INTO profile_log (userid,var1,var2,var3,var4,type,time) VALUES ('$_COOKIE[userid]','$_COOKIE[userid]','$_COOKIE[username]','$info[id]','','2','$time')");
		header("location:/server_info/$info[ip]");
	}
} else if (isset($_GET['task']) && $_GET['task'] == "ownership") {
  $ip			= addslashes($_GET['ip']);
  $vreme = time();
  
  $info = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE ip='$ip'"));
  
  if($_COOKIE['userid'] == "" OR $_COOKIE['username'] == ""){
   $_SESSION['error'] = "$lang[prijavitese]";
   header("location:/index.php");
   die();
  }
  
  if($info['ip'] == ""){
   $_SESSION['error'] = "$lang[servernepostoji]";
   header("location:/servers");
   die();
  }
  
  $server_id = $info['id'];
  $game = $info['game'];
  
require_once($_SERVER['DOCUMENT_ROOT'].'/GameQ.php'); 
$servers = array(
	array(
		'id' => $server_id,
		'type' => $game,
		'host' => $ip,
	)
);
$gq = new GameQ();
$gq->addServers($servers);
$gq->setOption('timeout', 4); // Seconds
$gq->setFilter('normalise');
$results = $gq->requestData();

foreach($results as $data){
  
  if($data['hostname'] == "MyGame" && $data['gq_online'] == "1"){
    mysql_query("UPDATE servers SET owner='$_COOKIE[username]',ownerid='$_COOKIE[userid]' WHERE id='$server_id'");
	$_SESSION['ok'] = "$lang[uspesno]";
	header("location:/server_info/$ip");
  } else {
    $_SESSION['error'] = "$lang[claim_server]";
	header("location:/server_info/$ip");
	die();
  } 
  
}
  
} else if (isset($_GET['task']) && $_GET['task'] == "s_delete") {
	$ip = addslashes($_GET['ip']);
	$id = addslashes($_GET['id']);
	
	$ip_i = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE ip='$ip'"));
	$id_i = mysql_fetch_array(mysql_query("SELECT * FROM shoutbox_s WHERE id='$id'"));
	
	if($ip_i['ip'] == ""){
		header("location:/servers/");
		die();
	}
	
	if($id_i['id'] == ""){
		header("location:/server_info/$ip");
		die();		
	}
	
	if($_COOKIE['userid'] == "" OR $_COOKIE['username'] == ""){
		$_SESSION['error'] = "$lang[prijavitese]";
		header("location:/login");
		die();
	}
	
	if($ip_i['ownerid'] == $_COOKIE['userid']){
		mysql_query("DELETE FROM shoutbox_s WHERE id='$id' AND sid='$ip_i[id]'");
		mysql_query("DELETE FROM obavestenja WHERE nod='$id_i[authorid]' AND time='$id_i[time]' AND type='1'");
		mysql_query("DELETE FROM profile_log WHERE userid='$id_i[authorid]' AND time='$id_i[time]' AND type='2'") or die(mysql_error());
		header("location:/server_info/$ip");
	} else {
		header("location:/server_info/$ip");
		die();	
	}
	
} else if (isset($_GET['task']) && $_GET['task'] == "feed_delete") {
	$username = addslashes($_GET['username']);
	$id = addslashes($_GET['id']);
	
	$u_i = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE username='$username'"));
	$id_i = mysql_fetch_array(mysql_query("SELECT * FROM profile_feed WHERE id='$id'"));
	
	if($u_i['username'] == ""){
		header("location:/memberlist");
		die();
	}
	
	if($id_i['id'] == ""){
		header("location:/member/$u_i[username]");
		die();		
	}
	
	if($_COOKIE['userid'] == "" OR $_COOKIE['username'] == ""){
		$_SESSION['error'] = "$lang[prijavitese]";
		header("location:/login");
		die();
	}
	
	if($id_i['userid'] == $_COOKIE['userid']){
		mysql_query("DELETE FROM profile_feed WHERE id='$id'");
		mysql_query("DELETE FROM obavestenja WHERE nod='$id_i[authorid]' AND time='$id_i[time]' AND type='3'");
		mysql_query("DELETE FROM profile_log WHERE userid='$id_i[authorid]' AND time='$id_i[time]' AND type='1'") or die(mysql_error());
		header("location:/member/$username");
	} else {
		header("location:/member/$username");
		die();	
	}
	
} else if(isset($_GET['task']) && $_GET['task'] == "edit_server"){
	$sid = addslashes($_POST['sid']);
	$forum = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['forum'])));
	$game = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['game'])));
	$location = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['location'])));
	$mod = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['mod'])));
	
	$test = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$sid'"));
	
	if($test['id'] == ""){
		header("location:/servers/");
		die();
	}
	
	if($_COOKIE['userid'] == "" OR $_COOKIE['username'] == ""){
		$_SESSION['error'] = "$lang[prijavitese]";
		header("location:/login");
		die();
	}

    if($test['ownerid'] == $_COOKIE['userid']){
		mysql_query("UPDATE servers SET forum='$forum',game='$game',location='$location',gamemod='$mod' WHERE id='$sid'");
		header("location:/server_info/$test[ip]");
		$_SESSION['ok'] = "$lang[uspesno]";
	} else {
		header("location:/server_info/$test[ip]");
		die();
	}
	
} else if (isset($_GET['task']) && $_GET['task'] == "add_community") {
  $naziv = mysql_real_escape_string($_POST['naziv']);
  $forum = mysql_real_escape_string($_POST['forum']);
  $opis = mysql_real_escape_string($_POST['opis']);
  $owner = $_COOKIE['username'];
  $ownerid = $_COOKIE['userid'];
  $id = mysql_insert_id();
  $time = time();
  
	if($_COOKIE['userid'] == "" OR $_COOKIE['username'] == ""){
		$_SESSION['error'] = "$lang[prijavitese]";
		header("location:/login");
		die();
	}  
  
  if($naziv == "" || $forum == ""){
  $_SESSION['error'] = "$lang[sva_polja]";
  header("location:/index.php");
  die();
  } else {
  mysql_query("INSERT INTO community (naziv,forum,opis,owner,ownerid) VALUES ('$naziv','$forum','$opis','$owner','$ownerid')");
  header("location:/communities");
  }
} else if (isset($_GET['task']) && $_GET['task'] == "edit_community") {
  $id = $_POST['id'];
  $naziv = mysql_real_escape_string(addslashes($_POST['naziv']));
  $forum = mysql_real_escape_string(addslashes($_POST['forum']));
  $opis = mysql_real_escape_string(addslashes($_POST['opis']));
  
  $info = mysql_fetch_array(mysql_query("SELECT * FROM community WHERE id='$id'"));
  
  if($info['id'] == ""){
    $_SESSION['error'] = "$lang[zajednicanepostoji]";
	header("location:/index.php");
	die();
  }
  
	if($_COOKIE['userid'] == "" OR $_COOKIE['username'] == ""){
		$_SESSION['error'] = "$lang[prijavitese]";
		header("location:/login");
		die();
	}  

  if($info['owner'] == $_COOKIE['username']){
   mysql_query("UPDATE community SET naziv='$naziv',forum='$forum',opis='$opis' WHERE id='$id'");
   header("location:/community_info/$id");
  } else {
   $_SESSION['error'] = "$lang[sva_polja]";
   header("location:/community_info/$id");
   die();
  }
} else if (isset($_GET['task']) && $_GET['task'] == "add_comm") {
  $comid = mysql_real_escape_string($_GET['comid']);
  $srvid = mysql_real_escape_string($_GET['srvid']);
  
  
  $info = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$srvid'"));
  $info2 = mysql_fetch_array(mysql_query("SELECT * FROM community WHERE id='$comid'"));
  
  if($info2['id'] == ""){
   $_SESSION['error'] = "$lang[zajednicanepostoji]";
   header("location:/index.php");
   die(); 
  }
  
  if($info['id'] == ""){
   $_SESSION['error'] = "$lang[servernepostoji]";
   header("location:/index.php");
   die();
  }
  
	if($_COOKIE['userid'] == "" OR $_COOKIE['username'] == ""){
		$_SESSION['error'] = "$lang[prijavitese]";
		header("location:/login");
		die();
	}  
  
  if($info['owner'] == "$_COOKIE[username]" && $info2['owner'] == "$_COOKIE[username]"){
   mysql_query("INSERT INTO community_servers (comid,srvid) VALUES ('$comid','$srvid')");
   header("location:/community_info/$comid");
  } else {
   $_SESSION['error'] = "Error";
   header("location:/index.php");
   die();
  }
} else if (isset($_GET['task']) && $_GET['task'] == "remove_comm") {
  $comid = mysql_real_escape_string($_GET['comid']);
  $srvid = mysql_real_escape_string($_GET['srvid']);
  
  
  $info = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$srvid'"));
  $info2 = mysql_fetch_array(mysql_query("SELECT * FROM community WHERE id='$comid'"));
  
 if($info2['id'] == ""){
   $_SESSION['error'] = "$lang[zajednicanepostoji]";
   header("location:/index.php");
   die(); 
  }
  
  if($info['id'] == ""){
   $_SESSION['error'] = "$lang[servernepostoji]";
   header("location:/index.php");
   die();
  }
  
	if($_COOKIE['userid'] == "" OR $_COOKIE['username'] == ""){
		$_SESSION['error'] = "$lang[prijavitese]";
		header("location:/login");
		die();
	}  
  
  if($info['owner'] == "$_COOKIE[username]" && $info2['owner'] == "$_COOKIE[username]"){
   mysql_query("DELETE FROM community_servers WHERE comid='$comid' AND srvid='$srvid'");
   header("location:/community_info/$comid");
  } else {
   $_SESSION['error'] = "Error";
   header("location:/index.php");
   die();
  }
}  else if (isset($_GET['task']) && $_GET['task'] == "profil") {
  $ime = htmlspecialchars(addslashes(mysql_real_escape_string($_POST['ime'])));
	$prezime = htmlspecialchars(addslashes(mysql_real_escape_string($_POST['prezime'])));
	$email = htmlspecialchars(addslashes(mysql_real_escape_string($_POST['email'])));
	$oldpass = md5(htmlspecialchars(addslashes(mysql_real_escape_string($_POST['oldpass']))));
	$password = md5(htmlspecialchars(addslashes(mysql_real_escape_string($_POST['password']))));
	$hidemail = $_POST['hidemail'];
	
	$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$_COOKIE[userid]'"));
	
	if($oldpass == ""|$password == ""){} else if($oldpass == $info['password']){
	  mysql_query("UPDATE users SET password='$password' WHERE userid='$info[userid]'");
	  header("location:/member/$info[username]");
	  $_SESSION['ok'] = "$lang[uspesno]";
	} else {}
	
    if($info['userid'] == "" && $info['username'] == ""){
    $_SESSION['error'] = "Error";
	header("location:/index.php");
	die();
    } else {
	mysql_query("UPDATE users SET ime='$ime',prezime='$prezime',email='$email',hidemail='$hidemail' WHERE userid='$info[userid]' ");
	header("location:/member/$info[username]");
 	$_SESSION['ok'] = "$lang[uspesno]";
	}
} else if(isset($_GET['task']) && $_GET['task'] == "upload_avatar") {

   $path = "\avatars";
	
	$valid_formats = array("jpg", "png", "gif");
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];
			
			if(strlen($name))
				{
					list($txt, $ext) = explode(".", $name);
					if(in_array($ext,$valid_formats))
					{
					if($size<(1000000))
						{
							$actual_image_name = "avatar_".time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
							$tmp = $_FILES['photoimg']['tmp_name'];
							if (move_uploaded_file ($tmp, 
    $_SERVER['DOCUMENT_ROOT']."/avatars/$actual_image_name")) {  
	                            $time = time();							
								mysql_query("UPDATE users SET avatar='$actual_image_name' WHERE userid='$_COOKIE[userid]'");
                                $_SESSION['ok'] = "$lang[uspesno]";
								header("location:/member/$_COOKIE[username]");
								}
							else
								$_SESSION['error'] = "$lang[neuspesno]";
								header("location:/member/$_COOKIE[username]");
								die();
						}
						else
						$_SESSION['error'] = "$lang[max_1mb_fajl]";
								header("location:/member/$_COOKIE[username]");
								die();						
						}
						else
						$_SESSION['error'] = "$lang[pogresan_format_fajla]";
													header("location:/member/$_COOKIE[username]");
								die();
				}
				
			else
				$_SESSION['error'] = "$lang[izaberite_fajl]";
											header("location:/member/$_COOKIE[username]");
								die();
				
			exit;
		}
		

} else if(isset($_GET['task']) && $_GET['task'] == "profile_feed") {
	$userid = htmlspecialchars(addslashes(mysql_real_escape_string($_POST['userid'])));
	$message = htmlspecialchars(addslashes(mysql_real_escape_string($_POST['message'])));
	$author = $_COOKIE['username'];
	$authorid = $_COOKIE['userid'];
	$time = time();
	
	$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$userid'"));
  
    if($info['userid'] == ""){
      $_SESSION['error'] = "$lang[korisniknepostoji]";
      header("location:/index.php");
      die(); 
    }
  
  
	if($_COOKIE['userid'] == "" OR $_COOKIE['username'] == ""){
		$_SESSION['error'] = "$lang[prijavitese]";
		header("location:/login");
		die();
	}  
	
  if($message == ""){
  $_SESSION['error'] = "$lang[sva_polja]";
  header("location:/index.php");
  die();
  } else {
  mysql_query("INSERT INTO profile_feed (userid,message,author,authorid,time) VALUES ('$userid','$message','$author','$authorid','$time')");
  if($info['userid'] == $_COOKIE['userid']){} else {
		  mysql_query("INSERT INTO obavestenja (var,nza,nod,time,status,type) VALUES ('/member/$info[username]','$info[userid]','$_COOKIE[userid]','$time','0','3')");
  }
  mysql_query("INSERT INTO profile_log (userid,var1,var2,var3,var4,type,time) VALUES ('$_COOKIE[userid]','$_COOKIE[userid]','$_COOKIE[username]','$info[username]','$info[userid]','1','$time')");
  header("location:/member/$info[username]");
  }
} else if(isset($_GET['task']) && $_GET['task'] == "add_friend") {
	$userid = addslashes($_GET['userid']);
	$time = time();
	
	$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$userid'"));
	
	if($info['userid'] == ""){
      $_SESSION['error'] = "$lang[korisniknepostoji]";
      header("location:/index.php");
      die(); 		
	}
	
    if($_COOKIE['userid'] == "" OR $_COOKIE['username'] == ""){
		$_SESSION['error'] = "$lang[prijavitese]";
		header("location:/login");
		die();
	}
	
	$check = mysql_num_rows(mysql_query("SELECT * FROM zahtevi WHERE od='$userid' AND za='$_COOKIE[userid]' OR od='$_COOKIE[userid]' AND za='$userid'"));
	if($check > 0){
		$_SESSION['error'] = "Error";
		header("location:/panel/zahtevi");
		die();
	}

    if($userid == $_COOKIE['userid']){
		$_SESSION['error'] = "Error";
		header("location:/panel/zahtevi");
		die();		
	}	

    $kveri = mysql_num_rows(mysql_query("SELECT * FROM zahtevi WHERE za='$userid' AND od='$_COOKIE[userid]'"));
    if($kveri < 1){
		mysql_query("INSERT INTO zahtevi (od,za,status,time) VALUES ('$_COOKIE[userid]','$userid','0','$time')");
		$_SESSION['ok'] = "$lang[uspesno_pzahtev]";
		header("location:/member/$info[username]");
	} else {
		$_SESSION['error'] = "$lang[poslat_zahtev_vec]";
		header("location:/member/$info[username]");
		die();
	}	
	
	
} else if(isset($_GET['task']) && $_GET['task'] == "f_accept") {
  $id = addslashes($_GET['id']);
  $time = time();
  
  $info = mysql_fetch_array(mysql_query("SELECT * FROM zahtevi WHERE id='$id'"));
  $usr = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$info[za]'"));
  
  if($info['id'] == ""){
	  header("location:/panel/zahtevi");
	  die();
  }
  
  if($_COOKIE['userid'] == "" OR $_COOKIE['username'] == ""){
		$_SESSION['error'] = "$lang[prijavitese]";
		header("location:/login");
		die();
  }

  if($info['za'] == $_COOKIE['userid']){
	  mysql_query("UPDATE zahtevi SET status='1' WHERE id='$id'");
	  mysql_query("INSERT INTO obavestenja (var,nza,nod,time,status,type) VALUES ('/member/$usr[username]','$info[od]','$_COOKIE[userid]','$time','0','2')");

	  $_SESSION['ok'] = "$lang[uspesno]";
	  header("location:/panel/zahtevi");
  } else {
	  $_SESSION['error'] = "$lang[nemate_pristup]";
	  header("location:/index.php");
	  die();
  }
	
} else if(isset($_GET['task']) && $_GET['task'] == "f_decline") {
	
  $id = addslashes($_GET['id']);
  
  $info = mysql_fetch_array(mysql_query("SELECT * FROM zahtevi WHERE id='$id'"));
  
  if($info['id'] == ""){
	  header("location:/panel/zahtevi");
	  die();
  }
  
  if($_COOKIE['userid'] == "" OR $_COOKIE['username'] == ""){
		$_SESSION['error'] = "$lang[prijavitese]";
		header("location:/login");
		die();
  }

  if($info['za'] == $_COOKIE['userid'] OR $info['od'] == $_COOKIE['userid']){
	  mysql_query("DELETE FROM zahtevi WHERE id='$id'");
	  $_SESSION['ok'] = "$lang[uspesno]";
	  header("location:/panel/zahtevi");
  } else {
	  $_SESSION['error'] = "$lang[nemate_pristup]";
	  header("location:/index.php");
	  die();
  }	
	
} else if (isset($_GET['task']) && $_GET['task'] == "send_message") {
  $userid = addslashes($_POST['userid']);
  $title = addslashes(htmlspecialchars($_POST['title']));
  $message = addslashes(htmlspecialchars($_POST['message']));
  $time = time();
  $ip_adresa = $_SERVER['REMOTE_ADDR'];
  
  $info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$userid'"));
  
  if($_COOKIE['userid'] == "" OR $_COOKIE['username'] == ""){
		$_SESSION['error'] = "$lang[prijavitese]";
		header("location:/login");
		die();
  }
  
  if($info['userid'] == ""){
   $_SESSION['error'] = "$lang[korisniknepostoji]";
   header("location:/index.php");
   die();
  } else {
   mysql_query("INSERT INTO poruke (za,od,title,message,time,nza,lastanswer) VALUES ('$userid','$_COOKIE[userid]','$title','$message','$time','$userid','$time')");
  $_SESSION['ok'] = "$lang[uspesno]";
   header("location:/panel/poruke");
  }
} else if (isset($_GET['task']) && $_GET['task'] == "read-m") {
  $id = addslashes($_GET['id']);
  
  $info = mysql_fetch_array(mysql_query("SELECT * FROM poruke WHERE id='$id'"));
  
  if($info['id'] == ""){
    $_SESSION['error'] = "$lang[poruka_nepostoji]";
	header("location:/index.php");
	die();
  }
  
  if($_COOKIE['userid'] == "" OR $_COOKIE['username'] == ""){
		$_SESSION['error'] = "$lang[prijavitese]";
		header("location:/login");
		die();
  }
  
  if($info['nza'] == $_COOKIE['userid']){
   mysql_query("UPDATE poruke SET status='1' WHERE id='$id'");
   header("location:/panel/poruke/$id");
  } else {
   $_SESSION['error'] = "$lang[nemate_pristup]";
   header("location:/index.php");
   die();
  }
} else if (isset($_GET['task']) && $_GET['task'] == "answer_m") {
  
  $message = addslashes(htmlspecialchars($_POST['message']));
  $id = addslashes($_POST['id']);
  $author = $_COOKIE['username'];
  $authorid = $_COOKIE['userid'];
  $time = time();
  
  $info = mysql_fetch_array(mysql_query("SELECT * FROM poruke WHERE id='$id'"));
  
  if($_COOKIE['userid'] == "" OR $_COOKIE['username'] == ""){
		$_SESSION['error'] = "$lang[prijavitese]";
		header("location:/login");
		die();
  }
  
  if($info['id'] == ""){
   $_SESSION['error'] = "Error";
   header("location:/panel/poruke");
   die();
  } else {
   mysql_query("INSERT INTO messages_answers (mid,message,author,authorid,time) VALUES ('$id','$message','$author','$authorid','$time')");
   
   if($info['za'] == $_COOKIE['userid']){
     mysql_query("UPDATE poruke SET nza='$info[od]',status='0',lastanswer='$time' WHERE id='$id'");
   } else {
     mysql_query("UPDATE poruke SET nza='$info[za]',status='0',lastanswer='$time' WHERE id='$id'");
   }
   
   $_SESSION['ok'] = "$lang[uspesno]";
   header("location:/panel/poruke/$id");
  }  
} else if (isset($_GET['task']) && $_GET['task'] == "read-n") {
  $id = addslashes($_GET['id']);
  
  $info = mysql_fetch_array(mysql_query("SELECT * FROM obavestenja WHERE id='$id'"));
  
  if($info['id'] == ""){
    $_SESSION['error'] = "$lang[obavestenje_nepostoji]";
	header("location:/index.php");
	die();
  }
  
  if($_COOKIE['userid'] == "" OR $_COOKIE['username'] == ""){
		$_SESSION['error'] = "$lang[prijavitese]";
		header("location:/login");
		die();
  }
  
  $type = $info['type'];
  if($type == "1"){
	  $server = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$info[var]'"));
	  $var = "/server_info/$server[ip]";
  } else {
	  $var = $info['var'];
  }
  
  
  if($info['nza'] == $_COOKIE['userid']){
   mysql_query("UPDATE obavestenja SET status='1' WHERE id='$id'");
   header("location:$var");
  } else {
   $_SESSION['error'] = "$lang[nemate_pristup]";
   header("location:/index.php");
   die();
  }
} else if (isset($_GET['task']) && $_GET['task'] == "prijavi_server") {
  $sid = addslashes($_POST['sid']);
  $razlog = addslashes(htmlspecialchars($_POST['razlog']));
  $napomena = addslashes(htmlspecialchars($_POST['comment']));
  $author = $_COOKIE['username'];
  $authorid = $_COOKIE['userid'];
  $time = time();
  $ip_adresa = $_SERVER['REMOTE_ADDR'];
  
  $info = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$sid'"));
  
  if($_COOKIE['userid'] == "" OR $_COOKIE['username'] == ""){
		$_SESSION['error'] = "$lang[prijavitese]";
		header("location:/login");
		die();
  }
  
  if($info['id'] == ""){
   $_SESSION['error'] = "$lang[servernepostoji]";
   header("location:/index.php");
   die();
  } else {
   mysql_query("INSERT INTO prijave_s (sid,razlog,napomena,author,authorid,time,ip_adresa) VALUES ('$sid','$razlog','$napomena','$author','$authorid','$time','$ip_adresa')");
  $_SESSION['ok'] = "$lang[uspesno]";
   header("location:/server_info/$info[ip]");
  }
}
?>