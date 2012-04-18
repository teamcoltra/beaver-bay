<?php
include('template.php');
echo $head_template;
?>
<h2><span>How do I download?</span>&nbsp;</h2>
<div class="guide">

	<div id="intro">
		<p>This guide will show you how to download from The Beaver Bay.</p>

		<p>There are many different clients for bittorrent, this guide explains how to use <a href="http://www.utorrent.com/" title="µtorrent">µtorrent</a>.</p>
	</div>


<div class="guide">
<h2>µtorrent</h2>
<h3>Installing</h3>
<ol>
	<li>Download <a href="http://www.utorrent.com/downloads" title="Download µtorrent">µtorrent</a></li>
	<li>Install it.</li>
</ol>

<h3>Download</h3>
<ol>
	<li>Go to <a href="//beaverbay.ca/" title="The Beaver Bay">beaverbay.ca</a> and select a download. Click "<span class="highlight">Get this torrent</span>".</li>
	<li>Now your web browser might ask you what application you want to open the file with. <span class="highlight">Select µtorrent</span> and make sure the browser remembers your choise.</li>
	<li>Your files are now being downloaded in µtorrent.</li>
</ol>
<br>

<h3>Problems, questions?</h3>
<p>
Q: <i>How do I select which files to download within a torrent using magnets?</i><br>
A: Magnets are torrents, only the torrents are downloaded from the swarm of peers directly by your torrent client, not from TPB. So wait a few seconds till your client has connected and downloaded the torrent file with the metadata. Now choose your torrent in utorrent and in the Files tab select which files to download or not. Here's a video to explain it all: <a href="http://www.youtube.com/watch?v=KCIclko7Bc8" title="Youtube: Download Individual Files from Magnet Links in uTorrent [The Pirate Bay]">youtube.com/watch?v=KCIclko7Bc8</a></p>
<p>
Q: <i>Magnets doens't open in my bittorrent client</i><br>
A: The easiest way to fix this is to uninstall and then install µtorrent again.<br>Or fix your settings like this: <a href="http://www.youtube.com/watch?v=gpBN9cDObDU" title="Youtube: How to Download Torrents with Magnet Links">youtube.com/watch?v=gpBN9cDObDU</a>
</p>


<h3>Other info</h3>
<p>
Always try to upload at least as much as you download.<br>
Thats the way to keep the bittorrent network alive. 
</p>
<p>This guide was proudly used from The Pirate Bay</p>
<?php
echo $foot_template;
?>