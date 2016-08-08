
<html>
<head>
	<style>
	body{
		font-family: lato;
	}
	h1{
		font-size: 40px;
	}
	.lead{
		font-size: 20px;
	}
	.canvas{
		display: inline-block;
		margin: 0;
		padding: 0;
	}
	.slider-div{
		width: 400px;
		display: inline-block;
	}
	.label{
		display: inline-block;
		width: 120px;
	}
	</style>

	<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
</head>



<body>

	
	<div style="padding-top: 40px; text-align: center;">
		<h1>Image Splitter</h1>
		<p class="lead">Move the image to create something new.</p>
	</div><br><br>

	<div style="text-align: center;">
		<div class="label">Rotation</div><div id="rotation_slider" class="slider-div"></div><br><br>
		<div class="label">Position</div><div id="position_slider" class="slider-div"></div><br><br>
		<div class="label">Size</div><div id="size_slider" class="slider-div"></div><br><br>
		
		<!-- can't have line breaks at the end or it puts a space between the canvasses -->
		<canvas id="myCanvas" class="canvas" width="300" height="300">
		</canvas><canvas id="myCanvas2" class="canvas" width="300" height="300"></canvas>
	</div><br><br><br>
	
	
		
	<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.0/themes/blitzer/jquery-ui.css">
	<script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>

	<script>

		// set up sliders
		$(function() {
			$("#rotation_slider").slider({
				min: -1000,
				max: 1000,
				value: 0,
				slide: function( event, ui ) {
					val = $('#rotation_slider').slider("option", "value");
					rotation = val/300;
					draw_image();
				},
			});
		});

		$(function() {
			$("#position_slider").slider({
				min: -100,
				max: 100,
				value: 0,
				slide: function( event, ui ) {
					val = $('#position_slider').slider("option", "value");
					offset = val;
					draw_image();
				},
			});
		});	
		
		$(function() {
			$("#size_slider").slider({
				min: 50,
				max: 400,
				value: 100,
				slide: function( event, ui ) {
					val = $('#size_slider').slider("option", "value");
					size = val/100;
					draw_image();
				},
			});
		});
		
		// set up image positioning variables
		var width = 300;
		var height = 300;
		var offset = 0;
		var rotation = 0;
		var size = 1;

		var c = document.getElementById("myCanvas");
		var ctx = c.getContext("2d");
		
		var c2 = document.getElementById("myCanvas2");
		var ctx2 = c2.getContext("2d");
		
		var img = new Image();
		img.src = "http://localhost/personalsite/pics/daniel_petersen_2.jpg";
		img.onload = function () {
			imgWidth = this.width;
			imgHeight = this.height;
			widthRatio = imgWidth/width;
			draw_image();
		}
		
		function draw_image(){	
		
			ctx.setTransform(1, 0, 0, 1, 0, 0);		
			ctx.clearRect(0, 0, width, height);	
			
			ctx.translate(offset/widthRatio, 0);
			
			ctx.translate(width/2, height/2);
			ctx.rotate(rotation);		
			
			ctx.translate(-width/2, -height/2);
			ctx.drawImage(img, (width-width*size)/2, (height-height*size)/2, width*size, height*size);
			
			// ctx2
			ctx2.setTransform(1, 0, 0, 1, 0, 0);
			ctx2.clearRect(0, 0, width, height);
			
			ctx2.translate(-offset/widthRatio, 0);
			
			ctx2.translate(width/2, height/2);
			ctx2.rotate(-rotation);
			
			ctx2.scale(-1, 1);
			ctx2.translate(-width/2, -height/2);
			ctx2.drawImage(img, (width-width*size)/2, (height-height*size)/2, width*size, height*size);
			
		}
		
	</script>


