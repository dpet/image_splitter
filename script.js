

load_sliders();

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

$('#image-input').keyup(function(e){
    if(e.keyCode == 13)
    {
        load_image();
    }
});

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

function load_image(){
	
	url = $('#image-input').val();
	$('#image-input').val('');
	$('#load-button').text('...');
	
	img.src = url;
	img.onload = function () {
		imgWidth = this.width;
		imgHeight = this.height;
		widthRatio = imgWidth/width;
		draw_image();
		$('#load-button').text('Load');
	}
}

function load_sliders(){
	
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
}