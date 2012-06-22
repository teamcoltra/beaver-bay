<?php
include('include/httpscrape.php');
try{
			$timeout = 2;
			//Read only 4MiB of the scrape response
			$maxread = 1024 * 4;
			
			$scraper = new httptscraper($timeout,$maxread);
			$ret = $scraper->scrape('http://capt.pirateparty.ca:1337/announce',array('35a4be91db7da71370d647bfffabe93baf360f22'));
			
			print_r($ret);
		}catch(ScraperException $e){
			echo('Error: ' . $e->getMessage() . "<br />\n");
			echo('Connection error: ' . ($e->isConnectionError() ? 'yes' : 'no') . "<br />\n");
		}
?>