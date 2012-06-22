<?php
include('httpscrape.php');
//include('twitter.php');
function gzdecode($d){
	$f=ord(substr($d,3,1));
	$h=10;$e=0;
	if($f&4){
		$e=unpack('v',substr($d,10,2));
		$e=$e[1];$h+=2+$e;
	}
	if($f&8){
		$h=strpos($d,chr(0),$h)+1;
	}
	if($f&16){
		$h=strpos($d,chr(0),$h)+1;
	}
	if($f&2){
		$h+=2;
	}
	$u = gzinflate(substr($d,$h));
	if($u===FALSE){
		$u=$d;
	}
	return $u;
}

function trackers($torrent,$formagnet=false){
	$return=($formagnet==true)? null:'<ul>';
	if(isset($torrent['announce-list'])){
		$torrent['announce']=array_merge($torrent['announce-list'],array(array($torrent['announce'])));
	}
	foreach($torrent['announce'] as $tracker){
		$return .=($formagnet==true)?'&tr='.$tracker[0]:'<li>'.$tracker[0].'</li>';
	}
		$return .=($formagnet==true)?'&tr=http://capt.pirateparty.ca:1337/announce':'<li>http://capt.pirateparty.ca:1337/announce</li>';

	$return.=($formagnet==true)?null:'</ul>';
	return $return;
}

function trackerdb($torrent){
	if(isset($torrent['announce-list'])){
		$torrent['announce']=array_merge($torrent['announce-list'],array(array($torrent['announce'])));
	}
	$return = 'http://capt.pirateparty.ca:1337/announce';
	foreach($torrent['announce'] as $tracker){
		$return .=",".$tracker[0];
	}
	return $return;
}

function DHT($torrent){
	$return='<ul>';
	if(isset($torrent['nodes'])){
		foreach($torrent['nodes'] as $node){
			$return .='<li>'.$node[0].':'.$node[1].'</li>';
		}
	}
	return $return.'</ul>';
}

function output($torrent){
	$return=null;
	$torrentsize=null;
	$files='<ul>';
	$infovariable = $torrent["info"];
	$combinedsize = '';
	if (isset($infovariable["files"])){
		$filecount = "";
		foreach ($infovariable["files"] as $file){
			$filecount += "1";
			$multiname = $file['path'];
			$multitorrentsize = makesize ($file['length']);
			$torrentsize += $file['length'];
			$combinedsize = makesize($torrentsize);
			$strname = strip_tags ($multiname[0]);
			$strname = htmlentities($strname);
			$strname = strip_tags($strname);
			$files .= "<li>".ucfirst($strname)." (".$multitorrentsize.")</li>";
		}
	}else{
		$singletf = $infovariable['name'] ;
		$singletf  = strip_tags($singletf );
		$torrentsize = makesize($infovariable['length']);
		$singletf = htmlentities($singletf);
		$strname = strip_tags($singletf);
		$files .= "<li>".$strname." (".$torrentsize.")</li>";
		$combinedsize = $torrentsize;
	}

			$timeout = 2;
			//Read only 4MiB of the scrape response
			$maxread = 1024 * 4;
			
			$scraper = new httptscraper($timeout,$maxread);
			$torrentstats = $scraper->scrape('http://capt.pirateparty.ca:1337/announce',$torrent['hash']);
	$files.='
	<li>Total: '.$combinedsize.'</li>
	</ul>';

	//Lets Fix The Name
	
$simplename = $torrent['info']['name'];
$fixname = array("-", "_", ".exe", ".mov", ".avi", ".iso", ".zip");
$simplename = str_replace($fixname, " ", $simplename);
$boom = explode(" ", $simplename);

$randomnumbers = rand(10, 100);

/*
//$search = new TwitterSearch("Hello");
$results = $search->results();

$good = 0;
$bad = 0;
foreach($results as $result){
$text_n = toLink($result->text);
if (preg_match('#:-?[]DP)]|good|yay|awesome#', $text_n)) {
    $good++;
} else if (preg_match('#:-?[(/[]|bad|sad|horrible#', $text_n)) {
    $bad++;
}
}
*/

	$return ='
	<h2>'.$simplename.'</h2>
	<div class="row">
		<div class="span6">
			<p><u><b>Torrent Information:</b></u></p>
			<p><b>Original Name:</b> '.$torrent['info']['name'].'</p>
			<p><b>Hash:</b> '.$torrent['hash'].'</p>
			<p><b>Magnet Link (With All trackers):</b> <a href="magnet:?xt=urn:btih:'.$torrent['hash'].'&dn='.urlencode($torrent['info']['name']).'&tr='.trackers($torrent,true).'">Magnet Link</a></p>
			<p><b>Files &amp; Sizes:</b></p>
			'.$files.'

			<p><b>Trackers:</b></p>
			'.trackers($torrent).'
			<p><b>Decentralised Hash Table Hosts:</b></p>
			'.DHT($torrent).'
			<p><b>Comment:</b> '.$torrent['comment'].'</p>
			<p><b>Created By:</b> '.$torrent['created by'].'</p>
			<p><b>Creation Date:</b> '.date("F j, Y, g:i a",$torrent['creation date']).'</p>
			<p><b>Torrent Encoding:</b> '.$torrent['encoding'].'</p>
			<p><b>Seeds</b> '.$torrentstats[$torrent['hash']]['seeders'].'</p>
			<p><b>Seeds</b> '.$torrentstats[$torrent['hash']]['leechers'].'</p>
			<p><b>Completed</b> '.$torrentstats[$torrent['hash']]['completed'].'</p>
			<p><b>Alternative Locations:</b><br /><a target="_blank" href="http://torrage.ws/torrent/'.strtoupper($torrent['hash']).'.torrent">Mirror #1</a><font size="2"> (torrage.ws)</font> | <a target="_blank" href="http://torcache.com/torrent/'.strtoupper($torrent['hash']).'.torrent">Mirror #2</a> <font size="2">(torcache.com)</font></p>
		</div>
		<div class="span6">
			<p><a class="btn btn-success btn-large" style="width:100%;" href="magnet:?xt=urn:btih:'.$torrent['hash'].'&dn='.urlencode($torrent['info']['name']).'&tr='.trackers($torrent,true).'">&darr; Download Torrent (Magnet) &darr;</a>
			<p><img border=0 src="http://bitsnoop.com/api/fakeskan.php?img=1&hash=98C5C361D0BE5F2A07EA8FA5052E5AA48097E7F6" width=148 height=18 /></p>
			<form accept-charset="UTF-8" action="/torrents" class="form-horizontal" id="comment" method="post">
			<input type="hidden" name="torrenthash" value="'.$torrent['hash'].'">
      <div class="control-group">
        <label class="control-label" for="tags">Tags</label>
        <div class="controls">
          <input id="tags" name="tags" size="30" type="text" value="">
        </div>
      </div>

        <div class="control-group">
        <label class="control-label" for="audio">Audio/Video Quality</label>
        <div class="controls">
          <input id="audio" class="input-mini" name="audio" size="30" type="text" value="">
          <input id="video" class="input-mini" name="video" size="30" type="text" value="">
        </div>
      </div>

		<div class="control-group">
            <label class="control-label" for="inlineCheckboxes">Torrent Quality</label>
            <div class="controls">
              <label class="checkbox inline">
                <input type="radio" id="inlineCheckbox1" name="quality" value="good"> Good
              </label>
              <label class="checkbox inline">
                <input type="radio" id="inlineCheckbox2" name="quality" value="bad"> Bad (Corrupted, Password, etc)
              </label>
              <label class="checkbox inline">
                <input type="radio" id="inlineCheckbox3" name="quality" value="fake"> Fake
              </label>
            </div>
          </div>

      <div class="control-group">
        <label class="control-label" for="comment">Comment</label>
        <div class="controls">
          <textarea id="comment" name="comment" size="30"></textarea>
        </div>
      </div>
<input type="hidden" name="captcha1" value="'.$randomnumbers.'">
      <div class="form-actions" style="padding-left: 0px; text-align:center;">
        <div class="input-prepend">
                <span class="add-on" style="background:#FFF; color: #000; font-weight:bold; height: 27px;">CAPTCHA: '.$randomnumbers.'</span><input class="span2" style="height: 27px;" id="prependedInput" name="captcha2" size="16" type="text">
              </div> <input class="btn btn-large btn-info" name="commit" type="submit" value="Post It">
      </div>
</form>
		</div>
	</div>
	';
	
	$hashid = $torrent['hash'];
	$name = $torrent['info']['name'];
	$size = $combinedsize;
	$seeds = $torrentstats[$torrent['hash']]['seeders'];
	$leeches = $torrentstats[$torrent['hash']]['leechers'];
	$completed = $torrentstats[$torrent['hash']]['completed'];
	$trackers = trackerdb($torrent);
	$encoding = $torrent['encoding'];
	$createdby = $torrent['created by'];
	$comment = $torrent['comment'];
	$query = "INSERT INTO torrents (hashid,name,size,seeds,leeches,completed,createdby,trackers,encoding,comment) VALUES ('$hashid','$name','$size','$seeds','$leeches','$completed','$createdby','$trackers','$encoding','$comment')
  ON DUPLICATE KEY UPDATE seeds='$seeds', leeches='$leeches', completed='$completed'";
  mysql_query($query) 
or die(mysql_error());  

	return $return;
}

function verifyHash($input){
	return ((strlen($input) === 40 && preg_match('/^[0-9a-fA-F]+$/', $input))?true:false);
}

function makesize($bytes) {
	if ($bytes < 1000 * 1024)
	return number_format($bytes / 1024, 2)." KB";
	if ($bytes < 1000 * 1048576)
	return number_format($bytes / 1048576, 2)." MB";
	if ($bytes < 1000 * 1073741824)
	return number_format($bytes / 1073741824, 2)." GB";
	return number_format($bytes / 1099511627776, 2)." TB";
}


function curl_get($url){
	$return = '';
	(function_exists('curl_init')) ? '' : die('cURL Must be installed!');

	$curl = curl_init();
	$header[0] = "Accept: text/xml,application/xml,application/json,application/xhtml+xml,";
	$header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
	$header[] = "Cache-Control: max-age=0";
	$header[] = "Connection: keep-alive";
	$header[] = "Keep-Alive: 300";
	$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
	$header[] = "Accept-Language: en-us,en;q=0.5";
	$header[] = "Pragma: ";

	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:5.0) Gecko/20100101 Firefox/5.0 Firefox/5.0');
	curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_REFERER, $url);
	curl_setopt($curl, CURLOPT_ENCODING, 'gzip,deflate');
	curl_setopt($curl, CURLOPT_AUTOREFERER, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$html = curl_exec($curl);
	curl_close($curl);
	return $html;
}

?>