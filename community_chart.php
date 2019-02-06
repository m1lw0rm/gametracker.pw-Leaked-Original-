<?php 
include("connect_db.php");

$id = addslashes($_GET['id']);
	
$server_query	= mysql_query("SELECT * FROM community WHERE id='$id'");
$server_row		= mysql_fetch_assoc($server_query);

if($server_row['id'] == ""){
	header('Content-Type: image/png');
	$image = imagecreatefrompng("ime/no_data.png");
	    imagepng($image);
        imagedestroy($image);
		
} else {

$sql = "SELECT sum( num_players ) as `suma_igraca`, sum( max_players ) as `max_igraca`
 FROM `servers`
 WHERE
 `id` IN (SELECT `srvid` FROM `community_servers` WHERE `comid` = '{$id}')";

$tmp = mysql_fetch_assoc( mysql_query( $sql ) );
 if(empty($info['maxslots'])){
	 $numtest = $tmp['max_igraca'];
 } else {
	 $numtest = $info['maxslots'];
 }

$chart_x_fields		= $server_row['chart_updates'];
$chart_x_replace	= "0,2,4,6,8,10,12,14,16,18,20,22,24";
$chart_x_max		= $numtest;
$chart_data			= $server_row['playercount'];
$chart_url          = "http://chart.apis.google.com/chart?chf=bg,s,020202,18&chxl=0:$chart_x_fields&chxr=0,0,24|1,0,$chart_x_max&chxs=0,3793f0,9,0,lt|1,3793f0,9,1,lt&chxt=x,y&chs=300x150&cht=lc&chco=3793f0&chds=0,$chart_x_max&chd=t:$chart_data&chdlp=l&chg=0,-1,0,0&chls=1&chm=o,3793f0,0,-1,3&chma=10,10,10,10";


header('Content-Type: image/png');
$im = imagecreatefrompng($chart_url);
imagealphablending($im, false);
imagesavealpha($im, true);
imagepng($im);
imagedestroy($im);

}
?>