<?php
/*Template File*/

$pagetitle = "BeaverBay.ca - ".$curpagetitle;

if ($pagelinks == NULL){
$pagelinks = "<li><a href='#'>Home</a></li>
              <li><a href='#about'>About</a></li>
              <li><a href='#contact'>Contact</a></li>";
}

$headtemplate = "<!DOCTYPE html>
<html lang='en'>
  <head>
    <meta charset='utf-8'>
    <title>$pagetitle</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    
	<script src='/assets/js/jquery.tagsinput.js'></script>
<link rel='stylesheet' type='text/css' href='/assets/css/jquery.tagsinput.css' />

    <!-- Le styles -->
    <link href='/assets/css/bootstrap.css' rel='stylesheet'>
    <style type='text/css'>
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href='/assets/css/bootstrap-responsive.css' rel='stylesheet'>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src='http://html5shim.googlecode.com/svn/trunk/html5.js'></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel='shortcut icon' href='/assets/ico/favicon.ico'>
    <link rel='apple-touch-icon-precomposed' sizes='144x144' href='/assets/ico/apple-touch-icon-144-precomposed.png'>
    <link rel='apple-touch-icon-precomposed' sizes='114x114' href='/assets/ico/apple-touch-icon-114-precomposed.png'>
    <link rel='apple-touch-icon-precomposed' sizes='72x72' href='/assets/ico/apple-touch-icon-72-precomposed.png'>
    <link rel='apple-touch-icon-precomposed' href='/assets/ico/apple-touch-icon-57-precomposed.png'>
  <script type='text/javascript'>
  $('#tags').tagsInput();
  </script>
  </head>

  <body>

    <div class='navbar navbar-fixed-top'>
      <div class='navbar-inner'>
        <div class='container'>
          <a class='btn btn-navbar' data-toggle='collapse' data-target='.nav-collapse'>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
            <span class='icon-bar'></span>
          </a>
		  <a class='brand' href='/' style='top:-5px;'><img src='/assets/img/logo.png'></a>
          <a class='brand' href='/'>The Beaver Bay</a>
          <div class='nav-collapse'>
            <ul class='nav'>
		$pagelinks
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class='container'>";





$foottemplate = "
      <hr>

      <footer>
        <p>Copyright? LOL! We have no copyrights!</p>
      </footer>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<script src='/assets/js/jquery.js'></script>

  </body>
</html>";
?>