<?php 
$curpagetitle = "Home";

$pagelinks = "<li class='active'><a href='/'>Home</a></li>
              <li><a href='#about'>About</a></li>
              <li><a href='#contact'>Contact</a></li>";

set_include_path('include');
include('config.php');
include('BDecode.php');
include('BEncode.php');
include('functions.php');
include('template.php');

$uploads_dir = './torrentfiles/';
$error = '';
$output = '';

if(isset($_FILES['torrent'])){
	if(is_uploaded_file($_FILES['torrent']['tmp_name'])){
		$fd = fopen($_FILES['torrent']['tmp_name'], "rb");
		#Read the uploaded torrent
		$alltorrent = fread($fd, filesize($_FILES['torrent']['tmp_name']));
		#Decode the torrent and gather info into an array
		$torrent = BDecode($alltorrent);
		//print_r($torrent);
		//die;
		$torrent['hash'] = sha1(BEncode($torrent["info"]));
		#Varify the hash is 40 len then move the uploaded .torrent
		if(verifyHash($torrent['hash'])===true){
			$uploadedfile = $uploads_dir.$torrent['hash'].'.torrent';
			move_uploaded_file($_FILES['torrent']['tmp_name'], $uploadedfile);
		}else{
			$error='Only torrent files allowed.';
		}
		$output=output($torrent);
	}
}

if($_SERVER['REQUEST_METHOD']=='POST'){
	if(!empty($_POST['hash'])){
		if(verifyHash(trim($_POST['hash']))===true){

			$hash = strtoupper(trim($_POST['hash']));

			if(file_exists($uploads_dir.$hash.'.torrent')){
				//We Already have it
			}else{
				$torrentfile = 'http://torrage.com/torrent/'.$hash.'.torrent';
				$torrent = curl_get($torrentfile);
				//$torrent = gzdecode($torrent);
				file_put_contents($uploads_dir.strtoupper($hash).'.torrent',$torrent);
			}

			$fd = fopen($uploads_dir.$hash.'.torrent', "rb");
			#Read the uploaded torrent
			$alltorrent = fread($fd, filesize($uploads_dir.$hash.'.torrent'));
			#Decode the torrent and gather info into an array
			$torrent = BDecode($alltorrent);
			$torrent['hash'] = sha1(BEncode($torrent["info"]));
			$output=output($torrent);
		}else{
			$error='Not a real info hash.';
		}
	}
}

echo $headtemplate;
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

<?php if($error != '') {
	echo $error;

} else if ($output != '') {
	echo $output;
} else {
	echo "";
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