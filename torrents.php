<?php 
$curpagetitle = "Home";

$pagelinks = "<li><a href='/'>Home</a></li>
              <li><a href='/about'>About</a></li>
              <li class='active'><a href='/torrents'>Torrents</a></li>";

set_include_path('include');
include('config.php');
include('BDecode.php');
include('BEncode.php');
include('functions.php');
include('template.php');

echo $headtemplate;

if (isset($_POST['comment'])) {
	//die(print_r($_POST));
	$torrenthash = $_POST['torrenthash'];
	$tags = $_POST['tags'];
	$video = $_POST['video'];
	$audio = $_POST['audio'];
	$quality = $_POST['quality'];
	$comment = $_POST['comment'];
	$captcha1 = $_POST['captcha1'];
	$captcha2 = $_POST['captcha2'];

	if (preg_match("/mynameis/i", $captcha2)) {
	    $success = 1;
	    $name = str_replace("mynameis", "", $captcha2);
	} else if ($captcha1 == $captcha2) {
		$random = array("Anonymous","Jack Sparrow ","Osama Bin Ladin", "George Bush", "Stephen Harper", "Peter McKay", "Vic Towes", "Canuck", "Beaver Man", "Twisted Soul", "John McDonald", "Adrianne Carr", "Pirate Master", "Coolboy34", "s3xyChik69", "Jean Luc", "Worf", "Number 1", "Red Leader", "Dearth Vader", "Orion", "Michael Jackson", "Nathan Fillion", "Some Ugly Guy", "Some Sweetie Pie", "Michael J. Fox", "Don Cherry", "Communist", "Liberal", "NDP", "Conservative", "PotMan", "BC Bud", "Samuel L Jackson", "Yoda", "Star Gazer", "Star Scream", "Optimus Prime", "Wedge", "Peter Griffon", "Scooby Doo", "Yeho Yinnyman", "DA F?", "username here", "person guy", "Triangle Man", "Cher", "Adel", "Drunken Sailor");
		$rand_keys = array_rand($random,2);
	    $success = 1;
	    $name = $random[$rand_keys[0]];
	} else {
		$success = 0;
	}

	if ($success == 1) {
		$sql="SELECT torrentid  FROM `torrents` WHERE `hashid` = '$torrenthash';";
				$result=mysql_query($sql);
				$row=mysql_fetch_array($result);
				$torrentid=$row['torrentid'];
				$tags = str_replace(", ", ",", $tags);
				$tags = explode(',',$tags);				
				foreach($tags as $substr){
	   			mysql_query("insert into tags (tagword, taggedtorrent) values ('$substr', '$torrentid');");
	   		}
		mysql_query("INSERT INTO comments
					(torrentid, audio, video, quality, comment, name) VALUES('$torrentid', '$audio', '$video', '$quality', '$comment', '$name') ") or die(mysql_error()); 
				$host  = $_SERVER['HTTP_HOST'];
				$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
				$extra = "torrent/$torrenthash";
				header("Location: http://$host$uri/$extra");
	} else {
				$host  = $_SERVER['HTTP_HOST'];
				$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
				$extra = "torrent/$torrenthash/failed";
				header("Location: http://$host$uri/$extra");
	}
}
?>
</div>
	<div class="hero-unit">
		<div class="container">
			<div class="uploadbox">
				<h2 class="pagination-centered" style="padding-bottom: 10px;">Find A Torrent</h2>
				<div class="pagination-centered">
					<form method="POST" action="">
					  <p><input type="text" class="input-large search-query">
  <button type="submit" class="btn">Search</button></p>
					</form>
				</div>
			</div>
		</div>
	</div>

 <div class='container'>
 	<?php
	if (isset($_GET['id'])) { 
	echo "torrent pages offline -- sorry";
	} else {
		?>
<div class='row'>
	<div class='span6'>
		<h2>Recent Torrents</h2>
	</div>
	<div class='span6'>
		<h2>Highest Ranked Torrents</h2>
	</div>
</div>
<div class='row'>
	<div class='span6'>
		<h2>Most Completed Torrents</h2>
	</div>
	<div class='span6'>
		<h2>Newest Torrents By Tag</h2>
			<h3>Tag: "movie"</h3>
			<h3>Tag: "music"</h3>
			<h3>Tag: "book"</h3>
			<h3>Tag: "application"</h3>
	</div>
</div>
<?php
	}
	?>
</div>
	<div class="hero-unit" style="background:crimson !important;">
		<div class="container">
			<div class="uploadbox">
				<h2 class="pagination-centered ">Upload Your Torrents!</h2>
				<div class="boxright">
				<h3>Torrent</h3>
					<form method="POST" enctype="multipart/form-data" action="">
					<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
					  <p><input type="file" name="torrent" size="46">
					  <input type="submit" value="Upload &amp; Parse"></p>
					</form>
				</div>
				<div class="boxleft">
				<h3>InfoHash</h3>
					<form method="POST" action="">
					  <p><input type="text" name="hash" size="46"><input type="submit" value="Grab Torrent &amp; Parse"></p>
					</form>
				</div>
			</div>
		</div>
	</div>
<div class='container'>
<?php
echo $foottemplate;
?>
