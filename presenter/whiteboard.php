<html>


<body>
    <div class="white-board-tool" id="white-board-tool">
        <div class="tool-icon" id="tool-icon">
            <i class="bi-three-dots">

            </i>
        </div>
        <div class="white-board-tool-buttons">


            <div class="pencil white-board-tool-button" id="draw-marker-ico" onclick="drawTool()">
                <i class="bi-pencil">

                </i>
            </div>
            <div class="eraser white-board-tool-button" id="draw-eraser-ico" onclick="eraseTool()">
                <i class="bi-eraser">

                </i>
            </div>
            <div class="textbox white-board-tool-button" id="draw-text-ico" onclick="writeText()">



                <i class="bi-fonts">

                </i>
            </div>
            <div class="palette white-board-tool-button" id="draw-colors-ico" onclick="colorPickerTool()">
                <i class="bi-palette">
                </i>
                <div>
                    <input type="color" id="colorPicker" />
                </div>
            </div>
            <div class="undo white-board-tool-button" id="shapes-ico">
                <i class="bi-bounding-box-circles">

                </i>
                <div class="all-shapes">
                    <div class="circle white-board-tool-button" onclick="drawCircle()">
                        <i class="bi-circle">
                        </i>
                    </div>
                    <div class="square white-board-tool-button" onclick="drawRect()">
                        <i class="bi-square">
                        </i>
                    </div>
                    <div class="line white-board-tool-button" onclick="drawLine()">
                        <i class="bi-slash-lg">
                        </i>
                    </div>
                </div>

            </div>

            <script>
                $('#shapes-ico').hover(function() {

                    if ($('.all-shapes').css('display') == 'none') {
                        $('.all-shapes').show(300);
                    }




                }, function() {
                    $('.all-shapes').hide(300);
                });
            </script>

            <div class="redo white-board-tool-button" onclick="toggleTextSizeSlider()">
                <i class="bi-type">

                </i>
                <div style="font-size: 12px !important;" class="text-size-number">
                    12px
                </div>
            </div>
            <div class="text-size-slider">
                <div class="slider">
                    <input type="range" id="text-size" min="10" max="30" value="12" onchange="changeTextSize()">
                </div>
            </div>

            <script>
                function toggleTextSizeSlider() {
                    let textSizeSlider = $('.text-size-slider');
                    if (textSizeSlider.css('display') == 'none') {
                        $('.text-size-slider').show(500);
                    } else {
                        $('.text-size-slider').hide(500);
                    }

                }
            </script>
            <div class="redo white-board-tool-button" onclick="toggleDrawSizeSlider()">
                <i class="bi-record-circle">

                </i>
                <div style="font-size: 12px !important;" class="draw-size-number">
                    2px
                </div>
            </div>
            <div class="draw-size-place">
                <div class="slider">
                    <input type="range" id="draw-size" min="1" max="20" value="2" onchange="changeMarkerSize()">
                </div>
            </div>

            <script>
                function toggleDrawSizeSlider() {
                    let textSizeSlider = $('.draw-size-place');
                    if (textSizeSlider.css('display') == 'none') {
                        $('.draw-size-place').show(500);
                    } else {
                        $('.draw-size-place').hide(500);
                    }

                }
                //for change number written below icon for sizes
                function updatePxSizes() {
                    let drawSizeNumber = $('.draw-size-number');
                    let textSizeNumber = $('.text-size-number');
                    let drawSizeNumberValue = $('#draw-size').val();
                    let textSizeNumberValue = $('#text-size').val();
                    drawSizeNumber.html("" + drawSizeNumberValue + " px");
                    textSizeNumber.html("" + textSizeNumberValue + " px");

                }
                updatePxSizes()
            </script>
        </div>
        <div class="tool-toggle-button" onclick="whiteBoardToolToggle()">
            <div id="white-board-tool-toggle">
                <i class="bi-chevron-down"></i>
            </div>
        </div>



    </div>
    <script>
        function whiteBoardToolToggle() {
            if ($(".white-board-tool-buttons").css('display') == "none") {
                $(".white-board-tool-buttons").show(800);
                document.getElementById("white-board-tool-toggle").style.animation = "fullRotate 1s forwards";
            } else {
                $(".white-board-tool-buttons").hide(800);
                $(".white-board-color-picker").hide(500);
                document.getElementById("white-board-tool-toggle").style.animation = "backRotate 1s forwards";
            }
        }
    </script>


    <div class="pdf-tool shadow">
        <div class="previous-page hover-pointer mx-2" id="previous-page">
            <i class="bi-chevron-double-left"></i>
        </div>
        <div class="current-page mx-2">
            <span><span id="page_num"></span> of <span id="page_count"></span></span>
        </div>
        <div class="next-page hover-pointer mx-2" id="next-page">
            <i class="bi-chevron-double-right"></i>
        </div>
        <form id="pdf-form">
            <label for="pdf-file" class="new-file-upload hover-pointer mx-2 my-1"><i class="bi-file-earmark-plus"></i></label>
            <input id='pdf-file' type="file" style="display:none;" name="pdf-file" />
        </form>
        <form id="photo-form">
            <label for="photo-file" class="new-file-upload hover-pointer mx-2 my-1"><i class="bi-image"></i></label>
            <input id='photo-file' type="file" style="display:none;" name="photo-file" />
        </form>

        <div>
            <div class="new-file-upload hover-pointer" type="button" onclick="clearWhiteboard()"><i class="bi-file-earmark"></i></div>
        </div>


    </div>

    <div id="canvas-container">
        <canvas id="mainCanvas"></canvas>
    </div>

</body>



<script>
    var canvas = document.getElementById('mainCanvas'),
        ctx = canvas.getContext('2d'),
        hasInput = false,
        isDrawStart = false,
        isPress = false,
        marker_eraser_size = 2,
        text_size = 12,
        font = '12px sans-serif',
        currentTool = "marker",
        selectedColor = "#000";
    canvas.width = $('#canvas-container').width();
    canvas.height = $('#canvas-container').height();
    var coordinates = [];

    coordinates.push({
        type: "color",
        value: selectedColor
    }); // for initalize the selectedColor
    coordinates.push({
        type: "marker-eraser-size",
        value: marker_eraser_size
    }); // for initalize the selectedSize
    coordinates.push({
        type: "text-size",
        value: text_size.toString()
    }); // for initalize the selectedSize


    $(function() {
        $("#pdf-file").change(function(e) {

            var formData = new FormData();
            var form = $('#pdf-form')[0];
            $.ajax({
                url: 'functions/uploadPdf.php',
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {


                    if (!data.localeCompare('false')) {
                        alert('error in opening file ')


                    } else {
                        showPdf(data);


                    }
                }

            });
        })

        $("#photo-file").change(function(e) {

            var formData = new FormData();
            var form = $('#photo-form')[0];
            $.ajax({
                url: 'functions/uploadPhoto.php',
                type: "POST",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {

                    if (!data.localeCompare('false')) {
                        alert('error in opening file ')


                    } else {
                        showPhoto(data);


                    }
                }

            });
        })
    })

    //function to get offset to left and top of page

    function getOffsetLeft(elem) {
        var offsetLeft = 0;
        do {
            if (!isNaN(elem.offsetLeft)) {
                offsetLeft += elem.offsetLeft;
            }
        } while (elem = elem.offsetParent);
        return offsetLeft;
    }


    function getOffsetTop(elem) {
        var offsetTop = 0;
        do {
            if (!isNaN(elem.offsetTop)) {
                offsetTop += elem.offsetTop;
            }
        } while (elem = elem.offsetParent);
        return offsetTop;
    }

    var canvasTop = getOffsetTop(canvas);
    var canvasLeft = getOffsetLeft(canvas);


    // window.onload = function() {
    //
    //     // Fill Window Width and Height
    //   //canvas.width = window.innerWidth;
    // 	//canvas.height = window.innerHeight;
    //
    // 	// Set Background Color
    //     //ctx.fillStyle="#fff";
    //     //ctx.fillRect(0,0,canvas.width,canvas.height);
    // };




    function showPhoto(photoUrl) {
        coordinates.push({
            type: 'photo',
            url: photoUrl
        })
        canvas.style.backgroundImage = `url("${photoUrl}")`;
    }


    let DrawText = class {
        static hasInput = false;
        constructor() {
            ctx.globalCompositeOperation = "source-over";




        }
        click() {
            //console.log("here");
            canvas.addEventListener('click', DrawText.mouseDown, false);
            // canvas.onclick = function(e) {
            //     if (DrawText.hasInput) return;
            //     DrawText.addInput(e.pageX - canvasLeft, e.pageY - canvasTop);
            // };

        }
        static mouseDown(e) {
            //console.log("here2");
            if (DrawText.hasInput) return;
            DrawText.addInput(e.pageX, e.pageY);
        }


        removeEventListeners() {
            canvas.removeEventListener('click', DrawText.mouseDown, false);
            //canvas.removeEventListener('click',DrawText.click,false);
        }




        static addInput(x, y) {

            var input = document.createElement('textarea');

            //input.type = 'text';
            input.style.position = 'fixed';
            input.placeholder = 'Press Enter after you write...'
            input.style.fontSize = text_size;
            input.style.color = selectedColor;
            input.style.left = (x - 4) + 'px';
            input.style.top = (y - 4) + 'px';

            input.onkeydown = DrawText.handleEnter;
            document.body.onmousedown = function() {
                if (DrawText.hasInput) {
                    document.body.removeChild(input);
                    DrawText.hasInput = false;
                }
            };

            document.body.appendChild(input);

            input.focus();

            DrawText.hasInput = true;
        }
        static handleEnter(e) {
            var keyCode = e.keyCode;
            if (keyCode === 13) {
                DrawText.drawText(this.value, parseInt(this.style.left, 10), parseInt(this.style.top, 10));
                document.body.removeChild(this);
                DrawText.hasInput = false;

            }

        }
        static drawText(txt, x, y) {
            ctx.textBaseline = 'top';
            ctx.textAlign = 'left';
            ctx.font = text_size + 'px sans-serif';
            //console.log(text_size);
            ctx.fillStyle = selectedColor;
            console.log(canvasTop);
            ctx.fillText(txt, x - canvasLeft, y - canvasTop);
            coordinates.push({
                type: 'text',
                x: x,
                y: y,
                txt: txt
            });
            coordinates.push({
                type: 'idle'
            });
        }

    }

    let DrawTool = class {

        static pos = {
            x: 0,
            y: 0
        }
        // static offsetX = $("canvas").offset().left;
        // static offsetY = $("canvas").offset().top;
        // static startX;
        // static startY;
        // static isDown = false;
        // static prevX = null;
        // static prevY = null;
        // static prevR = null;



        static mouseDown(e) {
            DrawTool.pos.x = e.pageX - canvasLeft;
            DrawTool.pos.y = e.pageY - canvasTop;
            coordinates.push({
                type: 'marker',
                x: DrawTool.pos.x,
                y: DrawTool.pos.y,
                s: true
            });
        }
        constructor() {

            this.mouseFunctions = {
                // mouseDown: function mouseDown(e) {
                //     DrawTool.pos.x = e.pageX - canvasLeft;
                //     DrawTool.pos.y = e.pageY - canvasTop;
                //     coordinates.push({
                //         type: 'marker',
                //         x: DrawTool.pos.x,
                //         y: DrawTool.pos.y,
                //         s: true
                //     });
                // },

                mouseMove: function mouseMove(e) {
                    // mouse left button must be pressed
                    if (e.buttons !== 1) return;
                    ctx.beginPath();
                    ctx.lineWidth = marker_eraser_size;
                    ctx.lineCap = 'round';
                    ctx.strokeStyle = selectedColor;
                    ctx.moveTo(DrawTool.pos.x, DrawTool.pos.y); // from
                    DrawTool.mouseDown(e);
                    // coordinates.push({
                    //     type: 'marker',
                    //     x: DrawTool.pos.x,
                    //     y: DrawTool.pos.y,
                    //     s: true
                    // });

                    ctx.lineTo(DrawTool.pos.x, DrawTool.pos.y); // to

                    ctx.stroke(); // draw it!

                },

                mouseUp: function mouseUp(e) {
                    DrawTool.pos.x = e.pageX - canvasLeft;
                    DrawTool.pos.y = e.pageY - canvasTop;
                    coordinates.push({
                        type: 'marker',
                        x: DrawTool.pos.x,
                        y: DrawTool.pos.y,
                        s: false
                    });
                    coordinates.push({
                        type: 'idle'
                    });
                }

            }
        }


        drawTool() {
            canvas.addEventListener('mousedown', DrawTool.mouseDown, false);
            canvas.addEventListener('mouseup', this.mouseFunctions.mouseUp, false);
            canvas.addEventListener('mousemove', this.mouseFunctions.mouseMove, false);
        }

        removeEventListeners() {
            canvas.removeEventListener('mousedown', DrawTool.mouseDown, false);
            canvas.removeEventListener('mouseup', this.mouseFunctions.mouseUp, false);
            canvas.removeEventListener('mousemove', this.mouseFunctions.mouseMove, false);
        }





    }



    let EraseTool = class {
        // constructor() {
        //     this.isPress = true;
        //     this.old = null;
        //     this.mouseFunctions = {
        //         mouseDown: function mouseDown(e) {
        //             this.isPress = true;
        //             this.old = {
        //                 x: e.offsetX,
        //                 y: e.offsetY
        //             };
        //             coordinates.push({
        //                 type: 'eraser',
        //                 x: e.pageX - canvasLeft,
        //                 y: e.pageY - canvasTop,
        //                 size:marker_eraser_size,
        //                 s: true
        //             });
        //         },
        //         mouseMove: function mouseMove(e) {
        //             if (this.isPress) {
        //                 var x = e.offsetX;
        //                 var y = e.offsetY;
        //                 ctx.globalCompositeOperation = 'destination-out';
        //                 ctx.beginPath();
        //                 ctx.arc(x, y, marker_eraser_size, 0, 2 * Math.PI);
        //                 ctx.fill();
        //                 //ctx.lineWidth = marker_eraser_size;
        //                 ctx.beginPath();
        //                 ctx.moveTo(this.old.x, this.old.y);
        //                 ctx.lineTo(x, y);
        //                 ctx.stroke();
        //
        //                 this.old = {
        //                     x: x,
        //                     y: y
        //                 };
        //
        //             } else {
        //                 return;
        //             }
        //         },
        //         mouseUp: function mouseUp(e) {
        //             this.isPress = false;
        //             coordinates.push({
        //                 type: 'eraser',
        //                 x: e.pageX - canvasLeft,
        //                 y: e.pageY - canvasTop,
        //                 size:marker_eraser_size,
        //                 s: false
        //             });
        //         }
        //     }
        // }
        // erase() {
        //     canvas.addEventListener('mousedown', this.mouseFunctions.mouseDown, false);
        //     canvas.addEventListener('mousemove', this.mouseFunctions.mouseMove, false);
        //     canvas.addEventListener('mouseup', this.mouseFunctions.mouseUp, false);
        // }
        // removeEventListeners() {
        //     canvas.removeEventListener('mousedown', this.mouseFunctions.mouseDown, false);
        //     canvas.removeEventListener('mousemove', this.mouseFunctions.mouseMove, false);
        //     canvas.removeEventListener('mouseup', this.mouseFunctions.mouseUp, false);
        //     ctx.globalCompositeOperation = "source-over";
        // }





        static pos = {
            x: 0,
            y: 0
        }
        // static offsetX = $("canvas").offset().left;
        // static offsetY = $("canvas").offset().top;
        // static startX;
        // static startY;
        // static isDown = false;
        // static prevX = null;
        // static prevY = null;
        // static prevR = null;


        static mouseDown(e) {

            ctx.globalCompositeOperation = 'destination-out';

            EraseTool.pos.x = e.pageX - canvasLeft;
            EraseTool.pos.y = e.pageY - canvasTop;
            coordinates.push({
                type: 'eraser',
                x: EraseTool.pos.x,
                y: EraseTool.pos.y,
                s: true
            });
        }
        constructor() {

            this.mouseFunctions = {
                // mouseDown: function mouseDown(e) {
                //     DrawTool.pos.x = e.pageX - canvasLeft;
                //     DrawTool.pos.y = e.pageY - canvasTop;
                //     coordinates.push({
                //         type: 'marker',
                //         x: DrawTool.pos.x,
                //         y: DrawTool.pos.y,
                //         s: true
                //     });
                // },

                mouseMove: function mouseMove(e) {
                    // mouse left button must be pressed
                    if (e.buttons !== 1) return;

                    ctx.globalCompositeOperation = 'destination-out';

                    ctx.beginPath();
                    ctx.lineWidth = marker_eraser_size;
                    ctx.lineCap = 'round';
                    //ctx.strokeStyle = selectedColor;
                    ctx.moveTo(EraseTool.pos.x, EraseTool.pos.y); // from
                    EraseTool.mouseDown(e);
                    coordinates.push({
                        type: 'eraser',
                        x: EraseTool.pos.x,
                        y: EraseTool.pos.y,
                        s: true
                    });
                    ctx.lineTo(EraseTool.pos.x, EraseTool.pos.y); // to

                    ctx.stroke(); // draw it!

                },

                mouseUp: function mouseUp(e) {
                    EraseTool.pos.x = e.pageX - canvasLeft;
                    EraseTool.pos.y = e.pageY - canvasTop;
                    coordinates.push({
                        type: 'eraser',
                        x: EraseTool.pos.x,
                        y: EraseTool.pos.y,
                        s: false
                    });
                    coordinates.push({
                        type: 'idle'
                    });
                }

            }
        }


        erase() {
            canvas.addEventListener('mousedown', EraseTool.mouseDown, false);
            canvas.addEventListener('mouseup', this.mouseFunctions.mouseUp, false);
            canvas.addEventListener('mousemove', this.mouseFunctions.mouseMove, false);
        }

        removeEventListeners() {
            canvas.removeEventListener('mousedown', EraseTool.mouseDown, false);
            canvas.removeEventListener('mouseup', this.mouseFunctions.mouseUp, false);
            canvas.removeEventListener('mousemove', this.mouseFunctions.mouseMove, false);
            ctx.globalCompositeOperation = "source-over";
        }






    }

    let DrawRectangle = class {
        static rectangle = {}
        static drag = false;
        constructor() {
            this.mouseFunctions = {
                mouseDown: function mouseDown(e) {
                    DrawRectangle.rectangle.startX = e.pageX - canvasLeft;
                    DrawRectangle.rectangle.startY = e.pageY - canvasTop;
                    DrawRectangle.drag = true;
                },
                mouseMove: function mouseMove(e) {
                    if (DrawRectangle.drag) {
                        DrawRectangle.rectangle.w = (e.pageX - canvasLeft) - DrawRectangle.rectangle.startX;
                        DrawRectangle.rectangle.h = (e.pageY - canvasTop) - DrawRectangle.rectangle.startY;
                        //ctx.clearRect(0, 0, canvas.width, canvas.height);
                        DrawRectangle.draw();
                    }

                },
                mouseUp: function mouseUp() {
                    console.log("mouseUp");
                    DrawRectangle.drag = false;
                    coordinates.push({
                        type: 'idle'
                    });
                }
            }

        }
        drawRect() {
            canvas.addEventListener('mousedown', this.mouseFunctions.mouseDown, false);
            canvas.addEventListener('mouseup', this.mouseFunctions.mouseUp, false);
            canvas.addEventListener('mousemove', this.mouseFunctions.mouseMove, false);
        }

        static draw() {
            ctx.fillStyle = selectedColor;
            ctx.fill();
            ctx.fillRect(DrawRectangle.rectangle.startX, DrawRectangle.rectangle.startY, DrawRectangle.rectangle.w, DrawRectangle.rectangle.h);
            coordinates.push({
                type: 'rectangle',
                x: DrawRectangle.rectangle.startX,
                y: DrawRectangle.rectangle.startY,
                w: DrawRectangle.rectangle.w,
                h: DrawRectangle.rectangle.h
            });
        }

        removeEventListeners() {
            canvas.removeEventListener('mousedown', this.mouseFunctions.mouseDown, false);
            canvas.removeEventListener('mouseup', this.mouseFunctions.mouseUp, false);
            canvas.removeEventListener('mousemove', this.mouseFunctions.mouseMove, false);
        }

    }




    let DrawCircle = class {
        static offsetX = $("canvas").offset().left;
        static offsetY = $("canvas").offset().top;
        static startX;
        static startY;
        static isDown = false;
        static prevX = null;
        static prevY = null;
        static prevR = null;

        constructor() {
            this.mouseFunctions = {
                mouseDown: function mouseDown(e) {
                    // e.preventDefault();
                    // e.stopPropagation();
                    DrawCircle.startX = parseInt(e.pageX - canvasLeft);
                    DrawCircle.startY = parseInt(e.pageY - canvasTop);
                    DrawCircle.isDown = true;
                },
                mouseMove: function mouseMove(e) {
                    if (!DrawCircle.isDown) {
                        return;
                    }
                    // e.preventDefault();
                    // e.stopPropagation();
                    var mouseX = parseInt(e.pageX - canvasLeft);
                    var mouseY = parseInt(e.pageY - canvasTop);
                    DrawCircle.draw(mouseX, mouseY);
                },
                mouseUp: function mouseUp(e) {
                    if (!DrawCircle.isDown) {
                        return;
                    }
                    //e.preventDefault();
                    //e.stopPropagation();
                    DrawCircle.isDown = false;
                    DrawCircle.prevX, DrawCircle.prevY, DrawCircle.prevR = null;
                    coordinates[coordinates.length - 1].s = true;
                    coordinates.push({
                        type: 'idle'
                    });
                }

            }
        }
        static draw(x, y) {
            if (DrawCircle.prevR != null && DrawCircle.prevX != null && DrawCircle.prevY != null) {
                ctx.clearRect((DrawCircle.prevX - DrawCircle.prevR) - 2, (DrawCircle.prevY - DrawCircle.prevR) - 2, ((DrawCircle.prevR * 2) + 4), ((DrawCircle.prevR * 2) + 4));
            }

            ctx.beginPath();
            /* ctx.moveTo(startX, startY + (y-startY)/2);
            ctx.bezierCurveTo(startX, startY, x, startY, x, startY + (y-startY)/2);
            ctx.bezierCurveTo(x, y, startX, y, startX, startY + (y-startY)/2); */
            ctx.arc(x, y, ((y - DrawCircle.startY) + (x - DrawCircle.startX)) / 2, 0 * Math.PI, 2 * Math.PI);
            coordinates.push({
                type: 'circle',
                x: x,
                y: y,
                r: ((y - DrawCircle.startY) + (x - DrawCircle.startX)) / 2,
                s: false
            });
            DrawCircle.prevX = x;
            DrawCircle.prevY = y;
            DrawCircle.prevR = ((y - DrawCircle.startY) + (x - DrawCircle.startX)) / 2;
            ctx.closePath();
            ctx.fillStyle = selectedColor;
            ctx.fill();
        }
        drawCircle() {
            canvas.addEventListener('mousedown', this.mouseFunctions.mouseDown, false);
            canvas.addEventListener('mouseup', this.mouseFunctions.mouseUp, false);
            canvas.addEventListener('mousemove', this.mouseFunctions.mouseMove, false);
        }

        removeEventListeners() {
            canvas.removeEventListener('mousedown', this.mouseFunctions.mouseDown, false);
            canvas.removeEventListener('mouseup', this.mouseFunctions.mouseUp, false);
            canvas.removeEventListener('mousemove', this.mouseFunctions.mouseMove, false);
        }


    }


    let DrawLine = class {
        static startPosition = {
            x: 0,
            y: 0
        };
        static lineCoordinates = {
            x: 0,
            y: 0
        };
        static prevLineCoordinates = null;
        static isDrawStart = false;

        static getClientOffset = (event) => {
            var {
                pageX,
                pageY
            } = event.touches ? event.touches[0] : event;
            var x = pageX - canvasLeft;
            var y = pageY - canvasTop;

            return {
                x,
                y
            }
        }

        constructor() {
            this.mouseFunctions = {
                mouseDown: function mouseDown(e) {
                    DrawLine.startPosition = DrawLine.getClientOffset(e);
                    DrawLine.isDrawStart = true;
                },
                mouseMove: function mouseMove(e) {
                    if (!DrawLine.isDrawStart) return;
                    DrawLine.lineCoordinates = DrawLine.getClientOffset(e);
                    DrawLine.clearCanvas();
                    DrawLine.prevLineCoordinates = DrawLine.lineCoordinates;
                    DrawLine.draw();
                },
                mouseUp: function mouseUp(e) {
                    DrawLine.isDrawStart = false;
                    DrawLine.prevLineCoordinates = null;
                    coordinates[coordinates.length - 1].s = true;
                    coordinates.push({
                        type: 'idle'
                    });
                }
            }
        }

        drawLine() {
            canvas.addEventListener('mousedown', this.mouseFunctions.mouseDown, false);
            canvas.addEventListener('mouseup', this.mouseFunctions.mouseUp, false);
            canvas.addEventListener('mousemove', this.mouseFunctions.mouseMove, false);
        }

        static clearCanvas = () => {
            if (DrawLine.prevLineCoordinates != null) {
                ctx.globalCompositeOperation = 'destination-out';
                ctx.beginPath();
                ctx.lineWidth = 5;
                ctx.moveTo(DrawLine.startPosition.x, DrawLine.startPosition.y);
                ctx.lineTo(DrawLine.prevLineCoordinates.x + 1, DrawLine.prevLineCoordinates.y + 1);
                ctx.lineTo(DrawLine.prevLineCoordinates.x + -1, DrawLine.prevLineCoordinates.y - 1);
                ctx.stroke();
                ctx.lineWidth = 1;
                ctx.globalCompositeOperation = "source-over";


            }
        }

        static draw() {
            ctx.beginPath();
            ctx.moveTo(DrawLine.startPosition.x, DrawLine.startPosition.y);
            ctx.lineTo(DrawLine.lineCoordinates.x, DrawLine.lineCoordinates.y);
            ctx.strokeStyle = selectedColor;
            ctx.stroke();
            coordinates.push({
                type: 'line',
                startx: DrawLine.startPosition.x,
                starty: DrawLine.startPosition.y,
                x: DrawLine.lineCoordinates.x,
                y: DrawLine.lineCoordinates.y,
                s: false
            });
        }

        removeEventListeners() {
            canvas.removeEventListener('mousedown', this.mouseFunctions.mouseDown, false);
            canvas.removeEventListener('mouseup', this.mouseFunctions.mouseUp, false);
            canvas.removeEventListener('mousemove', this.mouseFunctions.mouseMove, false);
        }
    }


    let et = new EraseTool();
    let dt = new DrawTool();
    let dr = new DrawRectangle();
    let dc = new DrawCircle();
    var dl = new DrawLine();
    let dtt = new DrawText();



    function removeEventListenersOfAll() {
        et.removeEventListeners();
        dt.removeEventListeners();
        dr.removeEventListeners();
        dc.removeEventListeners();
        dl.removeEventListeners();
        dtt.removeEventListeners();
    }

    function writeText() {
        removeEventListenersOfAll();
        dtt.click();


    }

    function drawTool() {
        removeEventListenersOfAll()
        dt.drawTool()
    }


    function eraseTool() {

        removeEventListenersOfAll()
        et.erase();


    }

    function drawRect() {
        removeEventListenersOfAll()
        dr.drawRect();
    }




    function drawCircle() {
        removeEventListenersOfAll()
        dc.drawCircle();
    }





    function drawLine() {
        removeEventListenersOfAll()
        dl.drawLine();
    }




    function changeMarkerSize() {

        marker_eraser_size = document.getElementById('draw-size').value;

        coordinates.push({
            type: "marker-eraser-size",
            value: marker_eraser_size
        });

        //change pixel number under icon
        updatePxSizes();


    }


    function changeTextSize() {

        text_size = document.getElementById('text-size').value;
        font = text_size + 'px sans-serif';
        coordinates.push({
            type: "text-size",
            value: text_size
        });

        //change pixel number under icon
        updatePxSizes();

    }


    function clearBoard() {

        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }

    function clearWhiteboard() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        coordinates.push({
            type: "clear"
        });
    }


    function colorPickerTool() {

        hasInput = true;
        circleIsDown = false;
        isDrawStart = false;
        isPress = false;

        document.getElementById('colorPicker').style.display = 'block';
        document.getElementById('colorPicker').addEventListener('input', function() {
            console.log(document.getElementById('colorPicker').value);
            selectedColor = document.getElementById('colorPicker').value;
            coordinates.push({
                type: "color",
                value: selectedColor
            });
        });

    }
    setInterval(saveData, 1000);

    function saveData() {
        const coordinates1 = JSON.stringify(coordinates);

        $.ajax({

            url: 'functions/savedata.php',

            type: 'post',


            data: {
                'coordinates1': coordinates1
            },


            success: function(data) {
                console.log(data);
            }

        });
    }
</script>

</html>

<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE-edge">

<script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.5.207/build/pdf.min.js">
</script>


<script>
    function showPdf(pdfUrl) {
        coordinates.push({
            type: 'pdf',
            url: pdfUrl
        })
        var pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 1.5,
            canvas = document.getElementById("mainCanvas"),
            ctx = canvas.getContext('2d');

        function renderPage(num) {
            pageRendering = true;
            pdfDoc.getPage(num).then((page) => {
                var viewport = page.getViewport({
                    scale: scale
                });


                var renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                }
                var renderTask = page.render(renderContext);
                renderTask.promise.then(() => {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        renderPage(pageNumPending);
                        pageNumPendig = null;
                    }
                });

            });

            document.getElementById('page_num').textContent = num;

        }


        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPendig = num;
            } else {
                renderPage(num);
            }
        }


        function onPrevPage() {
            if (pageNum <= 1) {
                return;
            }
            pageNum--;
            queueRenderPage(pageNum);
        }
        document.getElementById('previous-page').addEventListener('click', onPrevPage);


        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        }
        document.getElementById('next-page').addEventListener('click', onNextPage);


        /* function zoomOut() {
            scale -= 0.1;
            renderPage(pageNum);
        }
        document.getElementById('zoomOut').addEventListener('click', zoomOut);


        function zoomIn() {
            scale += 0.1;
            renderPage(pageNum);
        }
        document.getElementById('zoomIn').addEventListener('click', zoomIn); */



        pdfjsLib.getDocument(pdfUrl).promise.then((doc) => {
            //console.log(doc);
            pdfDoc = doc;
            document.getElementById('page_count').textContent = doc.numPages;
            renderPage(pageNum);

        });
    }
</script>
<?php include('style/whiteboard.php'); ?>