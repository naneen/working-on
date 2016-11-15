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
				<li><a href="project.php">Project</a></li>
				<li class="active"><a href="history.php">History <span class="sr-only">(current)</span></a></li>
				</ul>
				<a href="logout.php" type="button" class="btn btn-danger navbar-btn navbar-right"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout</a>
			</div>
		</div>
	</nav>
	<div class="jumbotron">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-12"><h1>History</h1></div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-12">
					<form class="form-inline">
						<div class="form-group">
							<label class="input-lg" for="input-day">Day</label>
							<select class="input-lg form-control" id="input-day" onChange="update()">
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="18">18</option>
								<option value="19">19</option>
								<option value="20">20</option>
								<option value="21">21</option>
								<option value="22">22</option>
								<option value="23">23</option>
								<option value="24">24</option>
								<option value="25">25</option>
								<option value="26">26</option>
								<option value="27">27</option>
								<option value="28">28</option>
								<option value="29">29</option>
								<option value="30">30</option>
								<option value="31">31</option>
							</select>
						</div>
						<div class="form-group">
							<label class="input-lg" for="input-month">Month</label>
							<select class="input-lg form-control" id="input-month" onChange="update()">
								<option value="1">January</option>
								<option value="2">February</option>
								<option value="3">March</option>
								<option value="4">April</option>
								<option value="5">May</option>
								<option value="6">June</option>
								<option value="7">July</option>
								<option value="8">August</option>
								<option value="9">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
							</select>
						</div>
						<div class="form-group">
							<label class="input-lg" for="input-year">Year</label>
							<select class="input-lg form-control" id="input-year" onChange="update()">
								<option value="2015">2015</option>
								<option value="2016">2016</option>
							</select>
						</div>
					</form>
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

	<script src="js/main.js"></script>
	<script src="js/history.js"></script>
</body>