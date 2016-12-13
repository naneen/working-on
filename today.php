<?php
session_start();
if(!isset($_SESSION['ez_wko_id']) || $_SESSION['ez_wko_id'] == -1) {
	header("location:index.php");
}

// set timeout period in seconds
$inactive = 7200;

// check to see if $_SESSION['timeout'] is set
if(isset($_SESSION['timeout']) ) {
        $session_life = time() - $_SESSION['timeout'];
        if($session_life > $inactive)
        { session_destroy(); header("Location: logout.php"); }
}
$_SESSION['timeout'] = time();
?>
<!DOCTYPE html>
<head>
	<link rel="shortcut icon" href="images/icon.ico">
	<title>Exzy Bot</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/jquery-ui.css" rel="stylesheet">
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
				<a class="navbar-brand" href="today.php">
					<img id="logo" alt="Brand" src="images/logo.png">
				</a>
			</div>
			<div class="collapse navbar-collapse" id="navbar-1">
				<ul class="nav navbar-nav">
					<li class="active"><a href="today.php">Today <span class="sr-only">(current)</span></a></li>
					<li><a href="project.php">Project</a></li>
					<li><a href="history.php">History</a></li>
					<li><a href="lesson.php">Lesson</a></li>
				</ul>
				<a href="logout.php" type="button" class="btn btn-danger navbar-btn navbar-right"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout</a>
			</div>
		</div>
	</nav>

	<div class="jumbotron">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-12">

					<!--div class="media">

						<div class="media-left media-middle">
							<img class="media-object img-circle online-img" width="120" src="images/profile2.jpg">
						</div>
						<div class="media-left media-middle">
							<img class="media-object img-circle online-img" width="120" src="images/profile3.jpg">
						</div>
						<div class="media-left media-middle">
							<img class="media-object img-circle online-img" width="120" src="images/profile8.jpg">
						</div>
						<div class="media-body media-middle" style="padding-left:20px;">
							<p style="font-size:3em;margin-bottom:0">Congratulations on Your <br><strong>Unity Certification!</strong> :D<br>
							</p>
							<p class="text-muted" style="font-size:1.5em;" title="exzyteam">#congrats #PGolfFighto!</p>
						</div>

					</div>

					<hr-->
					<!--2><kbd style="cursor:pointer">Congratuation to INK &amp; NOK!</kbd></h2-->
					<h1>What are you working on?</h1>
				</div>
			</div>
			<div class="row">
				<div id="input-group" class="form-group">
					<div class="col-xs-12 col-md-12">
						<div class="dropdown" id="dropdown-group">
							<textarea class="form-control input-lg dropdown-toggle" id="activity-input" data-toggle="dropdown" type="text" placeholder="Doing something with #project-name" rows="1" style="resize: none;"></textarea>
							<ul class="dropdown-menu" id="td-dropdown" style="display:none; width:100%; margin-top:0; overflow: auto;">
							</ul>
						</div>
					</div>
					<span id="help-block" class="help-block" style="display:none; padding-left:20px">You must include at least 1 tag.</span>
				</div>
			</div>
			<div class="row" style="padding-top:10px">
				<div class="col-xs-12 col-md-12">
					<p id="tag" style="font-size: 18px;"></p>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">

			<div class="col-xs-12 col-sm-8 col-md-9">
				<div id="ownActivity"></div>

				<div id="todogroup" style="display:none">
					<div id="checkboxlist"></div>

					<div class="checkbox" id="todo-textarea">
					  <label class="col-xs-12 col-md-12" style="margin-bottom: 20px;">
							<input type="checkbox" id="cb-infrontof-input" value="" style="margin-top: 10px;">
							<input class="form-control input ui-autocomplete-input" id="todo-input" type="text" placeholder="Add to do task with #project-name" rows="1" style="resize: none;">
							<span id="td-error" class="help-block" style="display:none;">You must include at least 1 tag.</span>
						</label>
					</div>

				</div>

				<hr id="divider">

				<div id="activity"></div>
			</div>

			<div class="hidden-xs col-xs-12 col-sm-4 col-md-3">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<h1><strong>EXZY WAY</strong></h1>
						<p><strong><small>The way to be Exzyllence</small></strong></p>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">

						<h3 class="text-info"><strong>THINK MORE</strong></h3>
						<p><small>Do it Beyond, Think and Voice your thought when you receive work assignment.</small></p>
						<p style="text-align: right;"><small><a href="#">more</a> | <a href="#">video</a></small></p>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<h3 class="text-warning"><strong>DAILY UPDATE</strong></h3>
						<p><small>Always update your senior your progress or problem. Say anything even your feeling.</small></p>
						<p style="text-align: right;"><small><a href="#">more</a> | <a href="#">video</a></small></p>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<h3 class="text-danger"><strong>REAL TESTING</strong></h3>
						<p><small>Test your work in real-environment setup (as possible as you can).</small></p>
						<p style="text-align: right;"><small><a href="#">more</a> | <a href="#">video</a></small></p>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<h3 class="text-success"><strong>GREEN LIGHT PASS</strong></h3>
						<p><small>Every project will be considered "finished" only when PO & QA say so.</small></p>
						<p style="text-align: right;"><small><a href="#">more</a> | <a href="#">video</a></small></p>
					</div>
				</div>
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
	<script src="js/jquery-ui.js"></script>
	<script src="js/jquery-ui.triggeredAutocomplete.js"></script>

	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/activity.js"></script>
	<script src="js/todo.js"></script>
</body>
