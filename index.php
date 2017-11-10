<?php require_once('header.html'); ?>

<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '856242944477715',
      xfbml      : true,
      version    : 'v2.7'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

<link href='includes/style.css' rel='stylesheet' type='text/css'>

<div style="text-align: center;">
	<h1>Image Splitter</h1>
	<p class="lead">
		A photo editor for mirroring images<br>
		Move the sliders to create something new<br>
		<a href="https://www.youtube.com/watch?v=hCHb6mRq3P4" target="_blank"><span class="video-link-text">See the demo video here</span></a>
	</p>	
</div><br><br>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-5 col-sm-offset-1 col-lg-4">
			<div class="col-xs-9 col-xs-offset-3" style="padding-bottom: 6px;">
				<div
				  class="fb-like"
				  data-share="true"
				  data-width="450"
				  data-show-faces="false">
				</div>
			</div>

			<div class="col-xs-3">				
				<label class="pull-right">Upload:</label>
			</div>

			<div class="col-xs-9">
				<input type="file" id="image-upload">
			</div><br><br>

			<div class="hidden-xs">
				<br>
			</div>

			<div class="col-xs-9 col-xs-offset-3">
				<button class="btn btn-primary btn-sm" onclick="reset()">Reset</button>
				<button class="btn btn-primary btn-sm" onclick="flip_image()">Flip</button>
				<button class="btn btn-primary btn-sm" onclick="set_quad()" id="quad_button">x4</button>
			</div>
		</div>

		<div class="col-xs-12 hidden-sm hidden-md hidden-lg">
			<br>
		</div>

		<div class="col-sm-6">
			<div class="col-xs-3">
				<label class="pull-right">Rotation:</label>
			</div>
			<div class="col-xs-7" style="padding-right: 4px;">
				<input type="range" class="form-control" min="-200" max="200" value="0" oninput="set_rotation(this.value)" onchange="set_rotation(this.value)" id="rotation_slider">
			</div>

			<div class="col-xs-2" style="padding: 0;">
				<button class="btn btn-primary btn-xs" onclick="rotate_45()" id="rotate_45_button">45°</button>
				<input type="number" class="rotation-input" id="rotation_input">
			</div>

			<div class="col-xs-3">
				<label class="pull-right">Position:</label>
			</div>
			<div class="col-xs-9 col-md-6">
				<input type="range" class="form-control" min="-100" max="100" value="0" oninput="set_offset(this.value)" onchange="set_offset(this.value)" id="position_slider">
			</div>
			<div class="col-xs-9 col-xs-offset-3 col-md-3 col-md-offset-0">
				<input type="range" class="form-control" min="-100" max="100" value="0" oninput="set_y_offset(this.value)" onchange="set_y_offset(this.value)" id="position_y_slider">
			</div>

			<div class="col-xs-3">
				<label class="pull-right">Size:</label>
			</div>
			<div class="col-xs-9">
				<input type="range" class="form-control" min="50" max="300" value="100" oninput="set_size(this.value)" onchange="set_size(this.value)" id="size_slider">
			</div>
		</div>
	</div>
</div>

<div style="text-align: center; margin-bottom: 6px;">	
	
	<!-- can't have line breaks at the end or it puts a space between the canvasses -->
	<canvas  id="myCanvas1" class="canvas">
	</canvas><canvas id="myCanvas2" class="canvas">			
	</canvas><br>
	<canvas id="myCanvas3" class="canvas">			
	</canvas><canvas id="myCanvas4" class="canvas">			
	</canvas>
	
	<canvas style="display: none;" id="tempCanvas" class="canvas"></canvas>
</div>	

<div class="download-container">
	<button class="btn btn-primary" style="display: inline-block;" onclick="create_image()">Create Image</button>
	<div style="width: 60px; display: inline-block; vertical-align: middle; margin-right: 10px;"><label class="pull-right" >Crop:</label></div>
	<input type="range" style="display: inline-block; width: 300px; vertical-align: middle;" min="0" max="350" value="0" oninput="set_crop(this.value)" onchange="set_crop(this.value)" id="crop_slider">
</div>

<hr style="margin: 4px auto; width: 800px; max-width: 100%;">

<div class="download-container" id="save_image_div">
	<h4>Images</h4>
	Right click and use 'Save image as' to download image or long press on mobile.<br>

	<div id="save_image_1_div" class="image_save_div" style="text-align: center;">
		<img id="save_image_1" class="saved-image"><br>
		<div style="padding: 2px;">
			<button class="btn btn-primary btn-sm add-button" onclick="add_saved_image(1)" id="add_image_1">add</button>
			<button class="btn btn-primary btn-sm" onclick="download(1)" id="download_1">download</button>
			<button class="btn btn-primary btn-sm" onclick="show_image(1)">view</button>
		</div>
	
	</div><div id="save_image_2_div" class="image_save_div" style="text-align: center;">
		<img id="save_image_2" class="saved-image"><br>
		<button class="btn btn-primary btn-sm add-button" onclick="add_saved_image(2)" id="add_image_2">add</button>
		<button class="btn btn-primary btn-sm" onclick="download(2)" id="download_2">download</button>
		<button class="btn btn-primary btn-sm" onclick="show_image(2)">view</button>
	
	</div><div id="save_image_3_div" class="image_save_div" style="text-align: center;">
		<img id="save_image_3" class="saved-image"><br>
		<button class="btn btn-primary btn-sm add-button" onclick="add_saved_image(3)" id="add_image_3">add</button>
		<button class="btn btn-primary btn-sm"onclick="download(3)" id="download_3">download</button>
		<button class="btn btn-primary btn-sm" onclick="show_image(3)">view</button>
	
	</div><div id="save_image_4_div" class="image_save_div" style="text-align: center;">
		<img id="save_image_4" class="saved-image"><br>
		<button class="btn btn-primary btn-sm add-button" onclick="add_saved_image(4)" id="add_image_4">add</button>
		<button class="btn btn-primary btn-sm" onclick="download(4)" id="download_4">download</button>
		<button class="btn btn-primary btn-sm" onclick="show_image(4)">view</button>
	</div>
</div>

<div id="image-viewer-div" style="display: none; margin-top: 6px; text-align: center; max-width: 100%;">
	<img id="image-viewer" style="max-width: 100%;"><br>
	<div style="width: 800px; margin: auto; text-align: left;">
		<button onclick="remove_image()" class="btn btn-primary btn-sm add-button">remove</button>
	</div>
</div>

<hr style="margin: 4px auto; width: 800px; max-width: 100%">

<div class="download-container">
	<h4>Samples</h4>
	<div class="image_save_div" style="display: inline-block;" >
		<img src="includes/images/tree_200.jpg" class="saved-image"><br>
		<button onclick="add_image(1)" class="btn btn-primary btn-sm add-button">add</button>
	</div>
	<div class="image_save_div" style="display: inline-block;" >
		<img src="includes/images/clouds_200.jpg" class="saved-image"><br>
		<button onclick="add_image(2)" class="btn btn-primary btn-sm add-button">add</button>
	</div>
	<div class="image_save_div" style="display: inline-block;" >
		<img src="includes/images/cat_200.jpg" class="saved-image"><br>
		<button onclick="add_image(3)" class="btn btn-primary btn-sm add-button">add</button>
	</div>
	<div class="image_save_div" style="display: inline-block;" >
		<img src="includes/images/city_200.jpg" class="saved-image"><br>
		<button onclick="add_image(4)" class="btn btn-primary btn-sm add-button">add</button>
	</div>
</div>
<br><br><br>
	
<link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.0/themes/blitzer/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>

<script src="includes/script.js"></script>

<?php require_once('footer.html');	?>	