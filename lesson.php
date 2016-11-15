<!DOCTYPE html>
<head>
	<link rel="shortcut icon" href="images/icon.ico">
	<title>Exzy Bot</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/jquery-ui.css" rel="stylesheet">
    <link href="css/lesson.css" rel="stylesheet">
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
					<li><a href="history.php">History</a></li>
					<li class="active"><a href="lesson.php">Lesson <span class="sr-only">(current)</span></a></li>
				</ul>
				<a href="logout.php" type="button" class="btn btn-danger navbar-btn navbar-right"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Logout</a>
			</div>
		</div>
	</nav>
	
	<div class="jumbotron">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-12 col-lg-12"><h1>Lesson</h1></div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
		    <div class="col-xs-12 col-sm-1 col-md-1">
            <center>
		        <h2>01</h2>                
            </center>
		    </div>
			<div class="col-xs-12 col-sm-4 col-md-5">
				<div class="visible-xs">
					<div class="embed-responsive embed-responsive-4by3">
						<video width="400" height="300px" controls class="vdo">
					    <source src="vdo/lesson1.mp4" type="video/mp4">
					    <p>
                          Your browser doesn't support HTML5 video.
                          <a href="vdo/lesson1.mp4">Download</a> the video instead.
                        </p>
					</video>
					</div>
				</div>
				
				<div class="visible-sm visible-md visible-lg">
					<video width="400" height="300px" controls class="vdo">
					    <source src="vdo/lesson1.mp4" type="video/mp4">
					    <p>
                          Your browser doesn't support HTML5 video.
                          <a href="vdo/lesson1.mp4">Download</a> the video instead.
                        </p>
					</video>
				</div>
			</div>
			<div class="col-xs-12 col-sm-3 col-md-1"></div>
			<div class="col-xs-12 col-sm-4 col-md-5 content">
				<div class="visible-xs xs-text">
					<div class="col-xs-12">
						<div class="row">
							<h3>LESSON 1: INTRODUCTION</h3>
						</div>
					</div>
					<div class="col-xs-12 topic">
						<div class="row speaker-div">
							<div class="speaker">
								<div class="col-xs-4 speaker-img-div">
									<img src="images/profile12.jpg" class="img-circle speaker-img" />
								</div>
								<div class="col-xs-7 speaker-text">
									<span>By: Nenin Ananbanchachai</span>
								</div>
								<div class="slide">
									<div class="slide-btn">
										<button class="btn btn-primary">Download slide</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="visible-sm visible-md visible-lg">

					<div class="col-xs-12 col-sm-12 col-md-12 topic">
						<div class="row">
							<h3>LESSON 1: INTRODUCTION</h3>
						</div>
						<div class="row speaker-div">
							<div class="speaker">
								<div class="col-sm-12 col-md-5 speaker-img-div">
									<img src="images/profile12.jpg" class="img-circle speaker-img" />
								</div>
								<div class="col-sm-12 col-md-7 speaker-text">
									<span>By: Nenin<br>Ananbanchachai</span>
								</div>
							</div>
						</div>
						<div class="row">
							<button class="btn btn-primary slide">Download slide</button>
						</div>
					</div>
					
				</div>
			</div>
			
		</div>
		<hr>

	</div>

</body>