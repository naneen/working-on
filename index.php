<?php
session_start();
if(isset($_SESSION['ez_wko_id']) && $_SESSION['ez_wko_id'] != -1) {
	header("location:today.php");
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
	<div class="filter">
		<div class="container popup">
			<div class="row">
				<div class="col-xm-12 col-md-12">
					<h2>Enter your PIN</h2>
				</div>
			</div>
			<div class="row" style="padding-top:10px">
				<div class="col-xm-12 col-md-12">
					<span class="text-danger" id="fail">Wrong PIN</span>
				</div>
			</div>
			<div class="row" style="padding-top:10px">
				<div class="col-xm-12 col-md-12">
					<input id="pin" name="pin" type="password" class="text-center form-control input-lg" placeholder="PIN" />
				</div>
			</div>
			<div class="row">
				<div class="col-xm-6 col-sm-6 col-md-6" style="padding-top:16px">
					<button onClick='login()' type="button" class="btn btn-xm btn-success btn-block btn-lg"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Login</button>
				</div>
				<div class="col-xm-6 col-sm-6 col-md-6" style="padding-top:16px">
					<button onClick='$(".filter").fadeOut()' type="button" class="btn btn-warning btn-block btn-lg"><span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> Cancel</button>
				</div>
			</div>
		</div>
	</div>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="today.php"><img alt="Brand" src="images/logo.png" height="100%"></a>
			</div>
		</div>
	</nav>
	<div class="jumbotron">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-12"><h1>EXZY BOT</h1></div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row" id="person-list">
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
	<script src="js/main.js"></script>
	<script src="js/index.js"></script>
</body>