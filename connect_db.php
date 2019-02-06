<?php
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

// Time ago function
function time_ago($ptime)
{
    $etime = time() - $ptime;

    if ($etime < 1)
    {
        return '0 seconds';
    }

    $a = array( 365 * 24 * 60 * 60  =>  'year',
                 30 * 24 * 60 * 60  =>  'month',
                      24 * 60 * 60  =>  'day',
                           60 * 60  =>  'hour',
                                60  =>  'minute',
                                 1  =>  'second'
                );
    $a_plural = array( 'year'   => 'years',
                       'month'  => 'months',
                       'day'    => 'days',
                       'hour'   => 'hours',
                       'minute' => 'minutes',
                       'second' => 'seconds'
                );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
        }
    }
}
					
// DB
// DB
define('DB_HOST', 'localhost');
define('DB_USER', 'westbalk_gtscript');
define('DB_PASS', 'newgenerationgt2017');
define('DB_NAME', 'westbalk_gtscript');

if (!$db=@mysql_connect(DB_HOST, DB_USER, DB_PASS))
{
	die ("<b>Doslo je do greske prilikom spajanja na MySQL...</b>");
}

if (!mysql_select_db(DB_NAME, $db))
{
	die ("<b>Greska prilikom biranja baze!</b>");
}


// gametracker config
$gt_allowed_countries	= array(
						'Serbia'			=> 'RS',
						'Bulgaria'       => 'BG',
						'Bosnia and Herzegovina' => 'BA',
						'Croatia'			=> 'HR',
						'Macedonia'			=> 'MK',
						'Montenegro'        => 'ME',
						'Albania'     => 'AL',
						'Romania'   => 'RO',
						'United States' => 'US',
						'Russia'   => 'RU',
						'Germany'  => 'DE',
						'Poland'  => 'PL',
						'Lithuania'  => 'LT',
						'Turkey'  => 'TR',
						'France'  => 'FR',
						'Australia'  => 'AU',
						'Brazil'  => 'BR',
						);


$gt_allowed_games		= array(
						'Counter-Strike'			=> 'cs16',
						'Counter-Strike: Source'    => 'css',
						'Counter-Strike: Global Offensive' => 'csgo',
						'Call Of Duty 2'            => 'cod2',
						'Call Of Duty 4'            => 'cod4',
						'MineCraft'                 => 'minecraft',
						'San Andreas Multiplayer'   => 'samp',
						'Team Fortress 2'           => 'tf2',
						'TeamSpeak 3'               => 'teamspeak3',
						);
// title
if($_GET['page'] == "")  {$title = "$lang[pocetna]"; $h_active = "active"; 

$breadcrumb = "
<li><a href='/index.php'> <i class='fa fa-home'></i>  </a></li>
<li class='active'> <span> $lang[pocetna] </span> </li>";
}
if($_GET['page'] == "login") {$title = "$lang[login]"; $l_active = "active"; 
$breadcrumb = "
<li><a href='/index.php'><i class='fa fa-home'></i> $lang[pocetna]</a></li>
<li class='active'> <span><i class='fa fa-key'></i> $lang[login] </span> </li>
";
}
if($_GET['page'] == "register") {$title = "$lang[register]"; $r_active = "active"; 
$breadcrumb = "
<li><a href='/index.php'><i class='fa fa-home'></i> $lang[pocetna]</a></li>
<li class='active'> <span><i class='fa fa-users'></i> $lang[register] </span> </li>
";}
if($_GET['page'] == "dodaj") {$title = "$lang[dodajserver]"; $d_active = "active";
$breadcrumb = "
<li><a href='/index.php'><i class='fa fa-home'></i> $lang[pocetna]</a></li>
<li class='active'> <span><i class='fa fa-plus'></i> $lang[dodajserver] </span> </li>
"; }
if($_GET['page'] == "games") {$title = "$lang[igre]"; $g_active = "active"; $breadcrumb = "
<li><a href='/index.php'><i class='fa fa-home'></i> $lang[pocetna]</a></li>
<li class='active'> <span><i class='fa fa-list'></i> $lang[igre] </span> </li>
"; }
if($_GET['page'] == "servers") {$title = "$lang[serveri]"; $s_active = "active"; 
$breadcrumb = "
<li><a href='/index.php'><i class='fa fa-home'></i> $lang[pocetna]</a></li>
<li class='active'> <span><i class='fa fa-gamepad'></i> $lang[serveri] </span> </li>
";}
if($_GET['page'] == "boost") {$title = "Boost"; }
if($_GET['page'] == "server_info") {
	$ip = addslashes($_GET['ip']);
	$info = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE ip='$ip'"));
	
	$title = "$info[hostname]";
	$s_active = "active";
	
$breadcrumb = "
<li><a href='/index.php'><i class='fa fa-home'></i> $lang[pocetna]</a></li>
<li><a href='/index.php'><i class='fa fa-gamepad'></i> $lang[serveri]</a></li>
<li class='active'> <span> $title </span> </li>
";
}
if($_GET['page'] == "server_info" AND $_GET['p'] == "banners") {
	$ip = addslashes($_GET['ip']);
	$info = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE ip='$ip'"));
	
	$title = "$info[hostname] banners";
	$s_active = "active";
}
if($_GET['page'] == "community_info") {
	$id = addslashes($_GET['id']);
	$info = mysql_fetch_array(mysql_query("SELECT * FROM community WHERE id='$id'"));
	
	$title = "$info[naziv]";
	$c_active = "active";
	
$breadcrumb = "
<li><a href='/index.php'><i class='fa fa-home'></i> $lang[pocetna]</a></li>
<li><a href='/communities'><i class='fa fa-cog'></i> $lang[zajednice]</a></li>
<li class='active'> <span> $title </span> </li>
";
}
if($_GET['page'] == "communities") {$title = "$lang[zajednice]"; $c_active = "active"; 
$breadcrumb = "
<li><a href='/index.php'><i class='fa fa-home'></i> $lang[pocetna]</a></li>
<li class='active'> <span> <i class='fa fa-cog'></i> $lang[zajednice] </span> </li>

"; }
if($_GET['page'] == "memberlist") {$title = "$lang[korisnici]"; $u_active = "active";
$breadcrumb = "
<li><a href='/index.php'><i class='fa fa-home'></i> $lang[pocetna]</a></li>
<li class='active'> <span> <i class='fa fa-users'></i> $lang[korisnici] </span> </li>

"; 
 }
if($_GET['page'] == "member") {
	$username = addslashes($_GET['username']);
	$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE username='$username'"));
	
	$title = "$info[username]";
	$u_active = "active";
	
$breadcrumb = "
<li><a href='/index.php'><i class='fa fa-home'></i> $lang[pocetna]</a></li>
<li><a href='/memberlist'><i class='fa fa-users'></i> $lang[korisnici]</a></li>
<li class='active'> <span> $title </span> </li>
";
}


if($_GET['page'] == "guestbook") {$title = "Guestbook"; $u_active = "active";
	$username = addslashes($_GET['username']);
	$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE username='$username'"));
	
	$title = "$info[username]";
	
$breadcrumb = "
<li><a href='/index.php'><i class='fa fa-home'></i> $lang[pocetna]</a></li>
<li><a href='/memberlist'><i class='fa fa-users'></i> $lang[korisnici]</a></li>
<li><a href='/member/$info[username]'>$info[username] </a></li>
<li class='active'> <span> Guestbook </span> </li>
";
}
if($_GET['page'] == "panel" AND $_GET['p'] == "zahtevi") {$title = "Zahtevi";
	$fr_active = "active";
	
$breadcrumb = "
<li><a href='/index.php'><i class='fa fa-home'></i> $lang[pocetna]</a></li>
<li><a href=''><i class='fa fa-list'></i> USERPANEL </a></li>
<li class='active'> <span> $lang[zahtevi] </span> </li>
";
 }
if($_GET['page'] == "panel" AND $_GET['p'] == "poruke") {$title = "Poruke"; 
	$msg_active = "active";
$breadcrumb = "
<li><a href='/index.php'><i class='fa fa-home'></i> $lang[pocetna]</a></li>
<li><a href=''><i class='fa fa-list'></i> USERPANEL </a></li>
<li class='active'> <span> $lang[inbox] </span> </li>
";
}
if($_GET['page'] == "panel" AND $_GET['p'] == "obavestenja") {$title = "Obavestenja"; 
	$ann_active = "active";
$breadcrumb = "
<li><a href='/index.php'><i class='fa fa-home'></i> $lang[pocetna]</a></li>
<li><a href=''><i class='fa fa-list'></i> USERPANEL </a></li>
<li class='active'> <span> $lang[obavestenja] </span> </li>
";
}
if($_GET['page'] == "panel" AND $_GET['p'] == "poruke" AND $_GET['id']){
	$id = addslashes($_GET['id']);
	$info = mysql_fetch_array(mysql_query("SELECT * FROM poruke WHERE id='$id'"));
	
	$title = "$info[title]";
	
}

// za bannere
$link = "http://gametracker.com";
?>