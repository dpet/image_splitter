
var width = 400;
var height = 400;
var display_width = 8;
var imgScaledWidth = 640;
var xCenter = 0;
var offset = 0;
var vertical_offset = 0;
var rotation = 0;
var rotation_dir = 1;
var size = 1;
var crop = 0;
var flip = false;
var quad = false;
var created_images = 0;

if(detect_ie())
	remove_download_buttons();

// 4 canvases are used to mask the mirrored images 
// and then combined into a single canvas when the image is created
var c1 = document.getElementById("myCanvas1");
var ctx1 = c1.getContext("2d");
var c2 = document.getElementById("myCanvas2");
var ctx2 = c2.getContext("2d");
var c3 = document.getElementById("myCanvas3");
var ctx3 = c3.getContext("2d");
var c4 = document.getElementById("myCanvas4");
var ctx4 = c4.getContext("2d");

var temp_canvas = document.getElementById("tempCanvas");
var temp_context = temp_canvas.getContext("2d");

set_canvasses();

var img = new Image();
set_image("includes/images/tree.jpg");

// initializes upload button
$('#image-upload').change(function(){
	var selectedFile = $('#image-upload')[0].files[0];	
	var reader = new FileReader();  
	
	reader.onload = function(event){
		set_image(event.target.result);
		$('#image-upload').val('');
	};

	reader.readAsDataURL(selectedFile);	
});

// lets the rotation input box work when the user hits enter
$('#rotation_input').keyup(function(e){
    if(e.keyCode == 13){
        rotation_input($('#rotation_input').val());
    }
});

$('#rotation_input').change(function(){
	rotation_input($('#rotation_input').val());
});

// draws images to each canvas depending on slider values
function draw_image(){
	xCenter = (width-width*size)/2 + imgScaledWidth*size/2;

	draw_context(ctx1, flip, true);
	draw_context(ctx2, !flip, true);
	if (quad){
		draw_context(ctx3, flip, false);
		draw_context(ctx4, !flip, false);
	}
	draw_crop_borders();
}

// draws to an individual canvas
function draw_context(context, left, top){
	context.setTransform(1, 0, 0, 1, 0, 0);		
	context.clearRect(0, 0, width, height);	

	if (left) {
		hor = -size;
		width_offset = width-(width-imgScaledWidth*size)/2;	
	}
	else {		
		hor = size;
		width_offset = (width-imgScaledWidth*size)/2;	
	}

	if (top) {
		vert = size;		
		height_offset = (height-height*size)/2;
	}
	else {
		vert = -size;
		height_offset = height-(height-height*size)/2;
	}

	context.translate(width_offset, height_offset);
	context.scale(hor, vert);	
	context.translate(offset, vertical_offset);	
	
	context.translate(imgScaledWidth/2, height/2);
	context.rotate(rotation);			
	context.translate(-imgScaledWidth/2, -height/2);
	
	context.drawImage(img, 0, 0, imgScaledWidth, height);
}

function draw_crop_borders(){
	ctx1.setTransform(1, 0, 0, 1, 0, 0);
	ctx2.setTransform(1, 0, 0, 1, 0, 0);
	ctx3.setTransform(1, 0, 0, 1, 0, 0);
	ctx4.setTransform(1, 0, 0, 1, 0, 0);

	ctx1.fillStyle = "#fff";	
	ctx1.fillRect(0, 0, crop, height);	

	ctx2.fillStyle = "#fff";	
	ctx2.fillRect(width-crop, 0, crop, height);

	ctx3.fillStyle = "#fff";	
	ctx3.fillRect(0, 0, crop, height);	

	ctx4.fillStyle = "#fff";	
	ctx4.fillRect(width-crop, 0, crop, height);
}

function flip_image(){
	flip = !flip;

	offset *= -1;
	$("#position_slider").val(get_offset());

	rotation *= -1;
	$("#rotation_slider").val(radians_to_degrees(rotation));
	$('#rotation_input').val(radians_to_degrees(rotation));

	draw_image();
}

// adds a new image to canvasses
function set_image(url){
	img.src = url;
	img.onload = function () {
		set_image_variables();
		draw_image();
		$('#load-button').text('Load');
	}
}

// gets width of image when height is the height of the canvas, used to find center.
function set_image_variables(){
	imgWidth = img.width;
	imgHeight = img.height;
	imgScaledWidth = height * imgWidth / imgHeight;
}

// quad is true when set to four images instead of two
function set_quad(){
	quad = !quad;

	if (quad){
		$("#quad_button").text('x2');
	}
	else{
		$("#quad_button").text('x4');
	}

	set_canvasses();
	set_image_variables()
	draw_image();
}

function set_canvasses(){
	if (quad){
		width = 400;
		height = 250;
		c3.style.display = "inline-block";
		c4.style.display = "inline-block";
		temp_canvas.height = 500;
	}
	else{
		width = 400;
		height = 400;
		c3.style.display = "none";
		c4.style.display = "none";
		temp_canvas.height = 400;
	}		
	c1.width = c2.width = c3.width = c4.width = width;
	c1.height = c2.height = c3.height = c4.height = height;
}

function reset(){
	if (flip)
		flip_image();

	offset = 0;
	$("#position_slider").val(offset);
	vertical_offset = 0;
	$("#position_y_slider").val(vertical_offset);
	rotation = 0;
	$("#rotation_slider").val(radians_to_degrees(rotation));
	$('#rotation_input').val(radians_to_degrees(rotation));
	size = 1;
	$("#size_slider").val(size*100);
	crop = 0;
	$("#crop_slider").val(crop);

	draw_image();
}

function set_offset(value){
	offset = value * width / 100;
	draw_image();
}

function get_offset(){
	return offset / (width / 100);
}

function set_y_offset(value){
	vertical_offset = value * height / 100 / 2;
	draw_image();
}

function set_rotation(value){
	rotation = degrees_to_radians(value);
	$('#rotation_input').val(value);
	draw_image();
}

function rotate_45(){
	var rotation_degrees = radians_to_degrees(rotation);
	rotation_degrees += 45 * rotation_dir;
	rotation_degrees = Math.round(rotation_degrees / 45) * 45;

	if (rotation_degrees > 200){
		rotation_degrees = 135;
		rotation_dir = -1;
	}
	else if (rotation_degrees < -200){
		rotation_degrees = -135;
		rotation_dir = 1;
	}
	rotation = degrees_to_radians(rotation_degrees);
	$("#rotation_slider").val(rotation_degrees);
	$('#rotation_input').val(rotation_degrees);
	draw_image();
}

function rotation_input(value){
	if (value > 200)
		value = 200;
	if (value < -200)
		value = -200;
	$('#rotation_input').val(value);

	rotation = degrees_to_radians(value);
	$("#rotation_slider").val(value);
	draw_image();
}

function set_size(value){
	size = value/100;
	draw_image();
}

function set_crop(value){
	crop = value;
	draw_image();
}

function download(num){
	var temp_link = document.createElement('a');

	if (num === 1)
		temp_link.href = image_save_1.src;
	else if (num === 2)
		temp_link.href = image_save_2.src;
	else if (num === 3)
		temp_link.href = image_save_3.src;
	else if (num === 4)
		temp_link.href = image_save_4.src;

	temp_link.download = "output.jpg";
	document.body.appendChild(temp_link);
	temp_link.click();
	document.body.removeChild(temp_link);
}

// adds created image to canvasses
function add_saved_image(num){
	if (num === 1)
		set_image(image_save_1.src);
	else if (num === 2)
		set_image(image_save_2.src);
	else if (num === 3)
		set_image(image_save_3.src);
	else if (num === 4)
		set_image(image_save_4.src);
	reset();
}

// adds sample image to canvasses
function add_image(num){
	if (num === 1)
		set_image("includes/images/tree.jpg");
	else if (num === 2)
		set_image("includes/images/clouds.jpg");
	else if (num === 3)
		set_image("includes/images/cat.jpg");
	else if (num === 4)
		set_image("includes/images/city.jpg");
	reset();
}

// puts created image in viewer
function show_image(num){
	if (num === 1)
		$('#image-viewer').attr('src', image_save_1.src);
	else if (num === 2)
		$('#image-viewer').attr('src', image_save_2.src);
	else if (num === 3)
		$('#image-viewer').attr('src', image_save_3.src);
	else if (num === 4)
		$('#image-viewer').attr('src', image_save_4.src);
	
	$('#image-viewer-div').css('display', 'block');
}

function remove_image(){
	$('#image-viewer-div').css('display', 'none');
}

// combine canvasses to create final image that can be viewed or downloaded
function create_image(){
	created_images += 1;
	if (created_images === 5)
		created_images = 1;

	temp_canvas.width = (width-crop) * 2;

	temp_context.setTransform(1, 0, 0, 1, 0, 0);
	temp_context.fillStyle = "#eee";
	if (quad)	
		temp_context.fillRect(0, 0, (width-crop) * 2, height*2);	
	else 
		temp_context.fillRect(0, 0, (width-crop) * 2, height);	

	// image 1
	image = new Image();
	image.src = c1.toDataURL("image/png");

	temp_context.drawImage(image, -crop, 0, width, height);

	// image 2
	image.src = c2.toDataURL("image/png");

	temp_context.translate(width-crop, 0);
	temp_context.drawImage(image, 0, 0, width, height);

	if (quad){
		temp_context.setTransform(1, 0, 0, 1, 0, 0);

		// image 3
		image.src = c3.toDataURL("image/png");
		temp_context.drawImage(image, -crop, height, width, height);

		// image 4
		image.src = c4.toDataURL("image/png");
		temp_context.translate(width-crop, 0);
		temp_context.drawImage(image, 0, height, width, height);
	}

	if (created_images === 1){
		image_save_1 = new Image();
		image_save_1.src = temp_canvas.toDataURL("image/jpeg", .9);
		$('#save_image_1').attr('src', image_save_1.src);
		$('#save_image_1_div').css('display', 'inline-block');
	}

	if (created_images === 2){
		image_save_2 = new Image();
		image_save_2.src = temp_canvas.toDataURL("image/jpeg", .9);
		$('#save_image_2').attr('src', image_save_2.src);
		$('#save_image_2_div').css('display', 'inline-block');
	}

	if (created_images === 3){
		image_save_3 = new Image();
		image_save_3.src = temp_canvas.toDataURL("image/jpeg", .9);
		$('#save_image_3').attr('src', image_save_3.src);
		$('#save_image_3_div').css('display', 'inline-block');
	}

	if (created_images === 4){
		image_save_4 = new Image();
		image_save_4.src = temp_canvas.toDataURL("image/jpeg", .9);
		$('#save_image_4').attr('src', image_save_4.src);
		$('#save_image_4_div').css('display', 'inline-block');
	}
}

// download function doesn't work in IE
function remove_download_buttons(){
	$('#download_1').css('display', 'none');
	$('#download_2').css('display', 'none');
	$('#download_3').css('display', 'none');
	$('#download_4').css('display', 'none');
}

// detects IE because download function doesn't work in it
function detect_ie(){
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    return (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./));   
}

function degrees_to_radians(degrees) {
  return degrees * Math.PI / 180;
};

function radians_to_degrees(radians) {
  return radians * 180 / Math.PI;
};