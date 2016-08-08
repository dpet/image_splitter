
<html>
<head>	
	<link href='style.css' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
</head>

<body>
	
	<div style="padding-top: 20px; text-align: center;">
		<h1>Image Splitter</h1>
		<p class="lead">Move the sliders to create something new</p>
		<p>https://www.cesarsway.com/sites/newcesarsway/files/styles/large_article_preview/public/Common-dog-behaviors-explained.jpg</p>
		<p>http://www.catprotection.com.au/wp-content/uploads/2014/11/5507692-cat-m.jpg</p>
		
	</div><br>

	<div style="text-align: center;">
	
		<div class="menu-container">
			<div class="label">Rotation</div><div id="rotation_slider" class="slider-div"></div><br>
			<div class="label">Position</div><div id="position_slider" class="slider-div"></div><br>
			<div class="label">Size</div><div id="size_slider" class="slider-div"></div>
		</div>
	
		<div class="menu-container">
			<div class="label">Image URL</div><input id="image-input" class="input"></input>
			<button onclick="load_image()" class="load-button" id="load-button">Load</button><br>
			
			<div class="label">Upload Image</div><input type="file" id="image-upload">
		</div><br>
		
		<!-- can't have line breaks at the end or it puts a space between the canvasses -->
		<canvas id="myCanvas" class="canvas" width="300" height="300">
		</canvas><canvas id="myCanvas2" class="canvas" width="300" height="300"></canvas><br>
		
		
	</div><br><br><br>	
	
		
	<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.0/themes/blitzer/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
	
	<script src="script.js"></script>

	


