<?php 
$curpagetitle = "Home";

$pagelinks = "<li><a href='/'>Home</a></li>
              <li class='active'><a href='/about'>About</a></li>
              <li><a href='#contact'>Contact</a></li>";

set_include_path('include');
include('config.php');
include('BDecode.php');
include('BEncode.php');
include('functions.php');
include('template.php');

$uploads_dir = './torrents/';

echo $headtemplate;
?>
<div class="row">
	<div class="span8">
		<h2>A Public Torrent Index For The True North...</h2>
		<p>The Beaver Bay is the only 100% Canadian public torrent tracker on the internet. Our focus is to help people share the culture which makes us special, and to help give people the best peers possible.</p>
		<h2>Index or Tracker</h2>
		<p>Like The Pirate Bay, ISOHunt, etc, we are an indexer of torrents. We do not track them. However, we do use the open tracker provided by the <a href="http://pirateparty.ca">Pirate Party of Canada</a>, <code>http://capt.pirateparty.ca:1337/announce</code>. You do not have to add this tracker to your torrent, as we append the tracker to every torrent and hash that is added to the site.</p>
		<h2>A Reliable Service</h2>
		<p>Patriots of the Digital Revolution, the organization which runs The Beaver Bay has been operating since 2010 and are experts at redundant networking. Our backup servers, have backup servers. If our operators get arrested, we even have a shadow team which is ready to take over the site in our stead. We may go down from time to time, but The Beaver Bay wont be shut down by outside forces.</p>
		<p>Other websites that are run by Patriots of the Digital Revolution are:</p>
		<ul>
			<li><a href="http://tuebl.com">TUEBL - The Ultimate Ebook Library</a></li>
			<li><a href="http://tormovies.org">TorMovies - The Internet Movie Torrent Database</a></li>
			<li><a href="http://dotpirate.me">DotPirate - an OpenNIC TLD for Freedom</a></li>
		</ul>
	</div>
	<div class="span4">
			<h2>Blocking America</h2>
			<p>Too often when we use the web (without a VPN), we are given nice little messages telling us content isn't available in our country. We are not nationalists but our service was designed for Canadians, and since the United States likes to have people extradited for running filesharing websites, we are blocking access to American users.</p>
			<p>This may be a decision that we reverse later, but our goal is to provide the best service for Canadians that we can possibly give, and for the time being, that means we are blocking America.</p>
	</div>
</div>
<?php
echo $foottemplate;
?>