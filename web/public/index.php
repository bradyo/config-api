<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Config API - configuration as a service">
    <link rel="shortcut icon" href="assets/ico/favicon.png">

    <title>Config API</title>

    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>
    
    <script src="assets/js/jquery.min.js"></script>
  </head>

  <body>
    <div id="navigation" class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><b>Config API</b></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#desc">Features</a></li>
            <li><a href="#showcase">Documentation</a></li>
            <li><a href="#contact">Sign In</a></li>
          </ul>
        </div>
      </div>
    </div>

	<div id="headerwrap">
	    <div class="container">
	    	<div class="row centered">
	    		<div class="col-lg-12">
					<h1><b>Configuration</b> in the <b>Cloud</b></h1>
					<h3>Power your web applications with type-safe, versionable configs.</h3>
                    <br><br><br>
	    		</div>
	    		
	    		<div class="col-lg-2">
                    <br><br><br><br><br>
	    			<h5>Amazing Results</h5>
	    			<p>Push new configuration properties directly out to your army of mission critical servers.</p>
	    		</div>
	    		<div class="col-lg-8">
	    			<img class="img-responsive" src="assets/img/app-bg.png" alt="">
	    		</div>
	    		<div class="col-lg-2">
                    <br><br><br><br><br>
	    			<h5>Intuitive Tools</h5>
	    			<p>Give DevOps the power to manage configs and monitor consumers
                        from our intuitive web interface.</p>
	    		</div>
	    	</div>
            <br><br>
	    </div>
	</div>

	<div id="intro">
		<div class="container">
			<div class="row centered">
				<h1>Designed With Distributed Web Applications in Mind</h1>
                <br><br>
				<div class="col-lg-4">
					<h3>Type-Safe Profiles</h3>
                    <p>Configuration profiles validated against typed schema specifications.</p>
                    <img src="assets/img/intro03.png" alt="">
                </div>
				<div class="col-lg-4">
					<h3>Versioned Updates</h3>
                    <p>Configuration changes are highly visible, tracked, and fully revertable.</p>
                    <img src="assets/img/intro02.png" alt="">
                </div>
				<div class="col-lg-4">
					<h3>Push Notifications</h3>
					<p>Configuration change events immediately pushed out to all subscribers.</p>
                    <img src="assets/img/intro01.png" alt="">
				</div>
			</div>
            <br><br><br><br>
	    </div>
	</div>

	<div id="showcase">
		<div class="container">
			<div class="row">
				<h1 class="centered">Some Screenshots</h1>
				<br>
				<div class="col-lg-8 col-lg-offset-2">
					<div id="carousel-example-generic" class="carousel slide">
					  <ol class="carousel-indicators">
					    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
					    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
					  </ol>
					  <div class="carousel-inner">
					    <div class="item active">
					      <img src="assets/img/item-01.png" alt="">
					    </div>
					    <div class="item">
					      <img src="assets/img/item-02.png" alt="">
					    </div>
					  </div>
					</div>
				</div>
			</div>
			<br>
			<br>
			<br>
		</div>
	</div>

	<div id="footerwrap">
		<div class="container">
			<div class="col-lg-12">
                <p class="centered">Check us out on <a href="https://github.com/bradyo/config-api">Github.com</a></p>
			</div>
		</div>
	</div>

    <script src="assets/js/bootstrap.js"></script>
	<script>
        $('.carousel').carousel({interval: 3500})
	</script>
  </body>
</html>
