<?php
session_start();

if(!isset($_SESSION['ez_wko_id']) || $_SESSION['ez_wko_id'] == -1) {
	header("location:index.php");
}
?>
<!DOCTYPE html>
<head>
	<link rel="shortcut icon" href="images/icon.ico">
	<title>Exzy Bot</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">

</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="today.php"><img alt="Brand" src="images/logo.png" height="100%"></a>
			</div>
			<div class="collapse navbar-collapse" id="navbar-1">
				<ul class="nav navbar-nav">
				<li><a href="today.php">Today</a></li>
				<li class="active"><a href="project.php">Project <span class="sr-only">(current)</span></a></li>
				<li><a href="history.php">History</a></li>
				</ul>
				<a href="logout.php" type="button" class="btn btn-danger navbar-btn navbar-right"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout</a>
			</div>
		</div>
	</nav>
	<div class="jumbotron">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-12"><h1>Project <small id="project-name"></small></h1></div>
			</div>
			<div class="row" style="padding:16px 20px; line-height:2em;">
				<strong>Date Created: </strong>
				<span id="created-time"></span></br>
				<strong>Last Used: </strong>
				<span id="last-use"></span></br>
				<strong>Total Working Time: </strong>
				<span id="total-time"></span></br>
			</div>
			<div class="row" style="padding-top:10px">
				<div class="col-xs-12 col-md-12" id="tag">
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-8 col-md-9" id="activity">
			</div>
			<div class="col-xs-12 col-sm-4 col-md-3">
			</div>
		</div>
	</div>

	<footer class="footer">
		<div class="container">
			<p class="text-muted">Copyright &copy; 2015 Exzy Company Limited</p>
		</div>
	</footer>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="js/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>


	<script type="text/javascript">
		var currentTag = <?php
		if(isset($_GET["tag"]))
			echo "'" . $_GET["tag"] . "'";
		else
			echo "null";
		?>;
	</script>

	<script src="js/main.js"></script>
	<script src="js/project.js"></script>
</body>
