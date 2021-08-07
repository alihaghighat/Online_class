
myCanvas = document.getElementById("myCanvas");
ctx = myCanvas.getContext("2d");
selectedColor = "#000";
var textarea = null;
var intTextBox = 0;

window.onload = function() {
	// var myCanvas = document.getElementById("myCanvas");
	// var ctx = myCanvas.getContext("2d");

    // Fill Window Width and Height
  myCanvas.width = window.innerWidth;
	myCanvas.height = window.innerHeight;

	// Set Background Color
    ctx.fillStyle="#fff";
    ctx.fillRect(0,0,myCanvas.width,myCanvas.height);
};

		function drawTool(){

      console.log("drawTool function");



    // Mouse Event Handlers
	if(myCanvas){
		var isDown = false;
		var canvasX, canvasY;
		ctx.lineWidth = 1;
    ctx.globalCompositeOperation="source-over";


		$(myCanvas)
		.mousedown(function(e){
			isDown = true;
			ctx.beginPath();
			canvasX = e.pageX - myCanvas.offsetLeft;
			canvasY = e.pageY - myCanvas.offsetTop;
			ctx.moveTo(canvasX, canvasY);
		})
		.mousemove(function(e){
			if(isDown !== false) {
				canvasX = e.pageX - myCanvas.offsetLeft;
				canvasY = e.pageY - myCanvas.offsetTop;
				ctx.lineTo(canvasX, canvasY);
				ctx.strokeStyle = selectedColor;
				ctx.stroke();

			}
		})
		.mouseup(function(e){
			isDown = false;
			ctx.closePath();
		});
	}

	// Touch Events Handlers
	draw = {
		started: false,
		start: function(evt) {

			ctx.beginPath();
			ctx.moveTo(
				evt.touches[0].pageX,
				evt.touches[0].pageY
			);

			this.started = true;

		},
		move: function(evt) {

			if (this.started) {
				ctx.lineTo(
					evt.touches[0].pageX,
					evt.touches[0].pageY
				);

				ctx.strokeStyle = selectedColor;
				ctx.lineWidth = 1;
				ctx.stroke();
			}

		},
		end: function(evt) {
			this.started = false;
		}
	};

	// Touch Events
	myCanvas.addEventListener('touchstart', draw.start, false);
	myCanvas.addEventListener('touchend', draw.end, false);
	myCanvas.addEventListener('touchmove', draw.move, false);

	// Disable Page Move
	document.body.addEventListener('touchmove',function(evt){
		evt.preventDefault();
	},false);



 }





function eraseTool(){

	// var url = 'https://cloud.githubusercontent.com/assets/4652816/12771961/5341c3c4-ca68-11e5-844c-f659831d9c00.jpg';
	// var canvas = document.getElementById('canvas');
	// var ctx = canvas.getContext('2d');
	// var img = new Image();
	// img.src = url;
	// img.onload = function () {
	//   var width = Math.min(500, img.width);
	//   var height = img.height * (width / img.width);
	//
	//   canvas.width = width;
	//   canvas.height = height;
	//   ctx.drawImage(img, 0, 0, width, height);
	// };

  console.log("eraseTool function");


	// var isPress = false;
	// var old = null;
	// myCanvas.addEventListener('mousedown', function (e){
	//   isPress = true;
	//   old = {x: e.offsetX, y: e.offsetY};
	// });
	// myCanvas.addEventListener('mousemove', function (e){
	//   if (isPress) {
	//     var x = e.offsetX;
	//     var y = e.offsetY;
	//     ctx.globalCompositeOperation = 'destination-out';
  //
  //
	//     ctx.beginPath();
	//     ctx.arc(x, y, 10, 0, 2 * Math.PI);
	//     ctx.fill();
  //
	//     ctx.lineWidth = 20;
	//     ctx.beginPath();
	//     ctx.moveTo(old.x, old.y);
	//     ctx.lineTo(x, y);
	//     ctx.stroke();
  //
	//     old = {x: x, y: y};
  //
	//   }
	// });
	// myCanvas.addEventListener('mouseup', function (e){
	//   isPress = false;
	// });



  // Mouse Event Handlers
  if(myCanvas){
  var isDown = false;
  var canvasX, canvasY;
  ctx.lineWidth = 20;
  ctx.globalCompositeOperation="destination-out";


  $(myCanvas)
  .mousedown(function(e){
    isDown = true;
    ctx.beginPath();
    canvasX = e.pageX - myCanvas.offsetLeft;
    canvasY = e.pageY - myCanvas.offsetTop;
    ctx.moveTo(canvasX, canvasY);
  })
  .mousemove(function(e){
    if(isDown !== false) {
      canvasX = e.pageX - myCanvas.offsetLeft;
      canvasY = e.pageY - myCanvas.offsetTop;
      ctx.lineTo(canvasX, canvasY);
      ctx.strokeStyle = selectedColor;
      ctx.stroke();

    }
  })
  .mouseup(function(e){
    isDown = false;
    ctx.closePath();
  });
  }

  // Touch Events Handlers
  draw = {
  started: false,
  start: function(evt) {

    ctx.beginPath();
    ctx.moveTo(
      evt.touches[0].pageX,
      evt.touches[0].pageY
    );

    this.started = true;

  },
  move: function(evt) {

    if (this.started) {
      ctx.lineTo(
        evt.touches[0].pageX,
        evt.touches[0].pageY
      );

      ctx.strokeStyle = selectedColor;
      ctx.lineWidth = 1;
      ctx.stroke();
    }

  },
  end: function(evt) {
    this.started = false;
  }
  };

  // Touch Events
  myCanvas.addEventListener('touchstart', draw.start, false);
  myCanvas.addEventListener('touchend', draw.end, false);
  myCanvas.addEventListener('touchmove', draw.move, false);

  // Disable Page Move
  document.body.addEventListener('touchmove',function(evt){
  evt.preventDefault();
  },false);





}


function colorPickerTool(){

document.getElementById('colorPicker').style.display = 'block';
document.getElementById('colorPicker').addEventListener('input',function(){
console.log(document.getElementById('colorPicker').value);
selectedColor = document.getElementById('colorPicker').value;
});

}


function textBoxTool(){

//   <div id="container" class="ui-widget-content">
// <h3 class="ui-widget-header">Containment</h3>
// <span id="draggable">*
// <input type="text "id="resizable" class="ui-state-active" value="This is input box">
// </span>
// </div>




// document.getElementById('divDraggable').style.display = 'block';
// //
// document.getElementById('textCloseBtn').addEventListener('click',function(){
// document.getElementById('divDraggable').style.display = 'none';
// });
//
//
//         textarea = myCanvas.createElement('textarea');
//         textarea.className = 'info';
//         textarea.id = 'text-area'+ intTextBox;
//         textarea.placeholder = 'type here...'
//         document.getElementById('divDraggable').appendChild(textarea);
//         intTextBox++;




//      $( "#resizable" ).draggable({containment: "#textBoxContainer"}).resizable({
// containment: "#textBoxContainer"
// });





// $(document).ready(function() {
//         $(function() { $("#divDraggable").draggable(); });
//
//     });



function mouseDownOnTextarea(e) {
    var x = textarea.offsetLeft - e.clientX,
        y = textarea.offsetTop - e.clientY;
    function drag(e) {
        textarea.style.left = e.clientX + x + 'px';
        textarea.style.top = e.clientY + y + 'px';
    }
    function stopDrag() {
        document.removeEventListener('mousemove', drag);
        document.removeEventListener('mouseup', stopDrag);
    }
    document.addEventListener('mousemove', drag);
    document.addEventListener('mouseup', stopDrag);
}
myCanvas.addEventListener('click', function(e) {
        textarea = document.createElement('textarea');
        textarea.className = 'info';
        textarea.id = 'text-area'+ intTextBox;
        textarea.addEventListener('mousedown', mouseDownOnTextarea);
        document.body.appendChild(textarea);
        intTextBox++;

    var x = e.clientX - myCanvas.offsetLeft,
        y = e.clientY - myCanvas.offsetTop;
    textarea.value = "x: " + x + " y: " + y;
    textarea.style.top = e.clientY + 'px';
    textarea.style.left = e.clientX + 'px';
});





}


