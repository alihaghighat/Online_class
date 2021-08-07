<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pdfjs-dist@2.5.207/build/pdf.min.js"></script>

<div id="canvas-container" style="width:100%;height:100%">
    <canvas id="mainCanvas">

    </canvas>
</div>



<!-- <div class="pdf-tool shadow">
    <div class="previous-page hover-pointer mx-2" id="previous-page">
        <i class="bi-chevron-double-left"></i>
    </div>
    <div class="current-page mx-2">
        <span><span id="page_num"></span> of <span id="page_count"></span></span>
    </div>
    <div class="next-page hover-pointer mx-2" id="next-page">
        <i class="bi-chevron-double-right"></i>
    </div>
    <div class="new-file-upload hover-pointer mx-2" id="uploadPhoto" onclick="setPhotoBackground()">
        <i class="bi-file-earmark-plus"></i>
    </div>
    <div class="new-file-upload hover-pointer mx-2" id="uploadPhoto" onclick="setPhotoBackground()">
        <i class="bi-image"></i>
    </div>


</div> -->





<!-- <style>
    .pdf-tool {
        position: fixed;
        background-color: #eee;
        display: flex;
        flex-direction: row;
        padding: 5px;
        border-radius: 5px;
        left: 100px;
        align-items: center;

    }

    .new-file-upload {
        padding: 5px;
        border-radius: 3px;
    }

    .new-file-upload:hover {
        animation: change-background-upload-icon .4s forwards;
    }

    @keyframes change-background-upload-icon {
        from {
            background-color: #eee;
        }

        to {
            background-color: #aaa;
        }
    }
</style>
<style>
    .hover-pointer:hover {
        cursor: pointer;

    }
</style> -->



<script>
    setInterval(getData, 1000);
    var canvas = document.getElementById('mainCanvas');
    var ctx = canvas.getContext('2d');
    //ctx.lineWidth = 100;
    //ctx.beginPath();
    canvas.width = $('#canvas-container').width();
    canvas.height = $('#canvas-container').height();
    var selectedColor = "#000";
    var marker_eraser_size = 2;
    var text_size = 12;

    //for checking pdf 
    var currentUrl = "";


    function getData() {

        $.ajax({

            url: 'functions/getdata.php',

            type: 'post',


            data: "",


            success: function(data) {
                //JSON.parse(data).map((item) => coordinates.push(item));
                render(JSON.parse(data));
            }

        });
    }




    function render(coordinates) {

        //console.log(coordinates);
        var currentType = coordinates[0].type;
        var firstIndex = 0;
        var lastIndex = 0;
        while (true) {

            if (lastIndex == coordinates.length) {
                console.log(`last index = ${lastIndex}`);
                switch (currentType) {
                    case "marker":
                        drawMarker(coordinates.slice(firstIndex, lastIndex));
                        break;

                    case "rectangle":
                        drawRectangle(coordinates.slice(firstIndex, lastIndex));
                        break;

                    case "circle":
                        drawCircle(coordinates.slice(firstIndex, lastIndex));
                        break;

                    case "line":
                        drawLine(coordinates.slice(firstIndex, lastIndex));
                        break;

                    case "text":
                        drawText(coordinates.slice(firstIndex, lastIndex));
                        break;

                    case "eraser":
                        erase(coordinates.slice(firstIndex, lastIndex));
                        break;

                    case "color":
                        selectedColor = coordinates[lastIndex - 1].value;
                        break;

                    case "marker-eraser-size":
                        marker_eraser_size = coordinates[lastIndex - 1].value;
                        break;

                    case "text-size":
                        text_size = coordinates[lastIndex - 1].value;
                        break;

                    case "clear":
                        clearWhiteboard();
                        break;
                    case "pdf":
                        if (coordinates[firstIndex].url != currentUrl) {

                            currentType = coordinates[firstIndex].type;
                            showPdf(coordinates[firstIndex].url);
                            currentUrl = coordinates[firstIndex].url;
                            console.log(firstIndex);

                        }
                        break;
                    case "photo":
                        if (coordinates[firstIndex].url != currentUrl) {
                            currentType = coordinates[firstIndex].type;
                            showPhoto(coordinates[firstIndex].url);
                            currentUrl = coordinates[firstIndex].url;
                        }
                        break;
                    case "idle":
                        break;

                }
                break;
            }
            //console.log(coordinates.slice(firstIndex, lastIndex - 1));

            if (coordinates[lastIndex].type == currentType) {
                ++lastIndex;
            } else {
                console.log(coordinates);
                if (currentType == 'marker') {
                    drawMarker(coordinates.slice(firstIndex, lastIndex));
                    firstIndex = lastIndex;
                    currentType = coordinates[firstIndex].type;
                } else if (currentType == 'rectangle') {
                    drawRectangle(coordinates.slice(firstIndex, lastIndex));
                    firstIndex = lastIndex;
                    currentType = coordinates[firstIndex].type;
                } else if (currentType == 'circle') {
                    drawCircle(coordinates.slice(firstIndex, lastIndex));
                    firstIndex = lastIndex;
                    currentType = coordinates[firstIndex].type;
                } else if (currentType == 'line') {
                    drawLine(coordinates.slice(firstIndex, lastIndex));
                    firstIndex = lastIndex;
                    currentType = coordinates[firstIndex].type;
                } else if (currentType == 'text') {
                    drawText(coordinates.slice(firstIndex, lastIndex));
                    firstIndex = lastIndex;
                    currentType = coordinates[firstIndex].type;
                } else if (currentType == 'eraser') {
                    erase(coordinates.slice(firstIndex, lastIndex));
                    firstIndex = lastIndex;
                    currentType = coordinates[firstIndex].type;
                    ctx.globalCompositeOperation = 'source-over';
                } else if (currentType == 'color') {
                    selectedColor = coordinates[firstIndex].value;
                    //console.log(selectedColor);
                    firstIndex = lastIndex;
                    currentType = coordinates[firstIndex].type;
                } else if (currentType == 'marker-eraser-size') {
                    marker_eraser_size = coordinates[firstIndex].value;
                    firstIndex = lastIndex;
                    currentType = coordinates[firstIndex].type;
                } else if (currentType == 'text-size') {
                    text_size = coordinates[firstIndex].value;
                    firstIndex = lastIndex;
                    currentType = coordinates[firstIndex].type;
                } else if (currentType == 'clear') {
                    firstIndex = lastIndex;
                    currentType = coordinates[firstIndex].type;
                    clearWhiteboard();
                } else if (currentType == 'pdf') {
                    if (coordinates[firstIndex].url != currentUrl) {


                        showPdf(coordinates[firstIndex].url);
                        currentUrl = coordinates[firstIndex].url;
                        console.log(currentUrl);
                        console.log(coordinates[firstIndex].type);
                        console.log(firstIndex);

                    }

                    firstIndex = lastIndex;
                    currentType = coordinates[firstIndex].type;

                } else if (currentType == 'photo') {
                    if (coordinates[firstIndex].url != currentUrl) {


                        showPhoto(coordinates[firstIndex].url);
                        currentUrl = coordinates[firstIndex].url;

                    }
                    firstIndex = lastIndex;
                    currentType = coordinates[firstIndex].type;

                } else if (currentType == 'idle') {
                    firstIndex = lastIndex;
                    currentType = coordinates[firstIndex].type;
                }

            }

        }
        /*
                coordinates.map(item => {

                    if (item.type == 'rectangle') {
                        drawRectangle(item);
                    }

                    if (item.type == 'circle') {
                        drawCircle(item);
                    }

                    if (item.type == 'line') {
                        drawLine(item);
                    }
                    if (item.type == 'marker') {
                        drawMarker(item)
                    }


                })
         */
        //console.log(coordinates);

    }

    function drawMarker(coordinates) {

        ctx.beginPath();
        ctx.moveTo(coordinates[0].x, coordinates[0].y);
        ctx.strokeStyle = selectedColor;
        ctx.lineWidth = marker_eraser_size;

        for (index = 1; index < coordinates.length; index++) {
            if (coordinates[index].s == true) {
                ctx.lineTo(coordinates[index].x, coordinates[index].y);
            } else {
                if (index != coordinates.length - 1) {
                    ctx.moveTo(coordinates[index + 1].x, coordinates[index + 1].y);
                }
            }
        }

        //ctx.closePath();
        ctx.stroke();

        // console.log(coordinates);





    }


    function drawRectangle(coordinates) {


        for (index = 0; index < coordinates.length; index++) {
            //if(coordinates[index].s == true){
            //console.log("inside");
            ctx.fillStyle = selectedColor;
            ctx.fillRect(coordinates[index].x, coordinates[index].y, coordinates[index].w, coordinates[index].h);
            //}
            // else{
            //   ctx2.moveTo(coordinates[index].x,coordinates[index].y);
            // }

        }
    }




    function drawCircle(coordinates) {

        ctx.beginPath();
        /* ctx.moveTo(startX, startY + (y-startY)/2);
        ctx.bezierCurveTo(startX, startY, x, startY, x, startY + (y-startY)/2);
        ctx.bezierCurveTo(x, y, startX, y, startX, startY + (y-startY)/2); */
        for (index = 0; index < coordinates.length; index++) {
            if (coordinates[index].s == true) {
                //console.log("inside");
                ctx.arc(coordinates[index].x, coordinates[index].y, coordinates[index].r, 0 * Math.PI, 2 * Math.PI);
            } else {
                ctx.moveTo(coordinates[index].x, coordinates[index].y);
            }

        }

        //ctx2.stroke();
        //ctx2.closePath();
        ctx.fillStyle = selectedColor;
        ctx.fill();



    }



    function drawLine(coordinates) {

        ctx.beginPath();
        /* ctx.moveTo(startX, startY + (y-startY)/2);
        ctx.bezierCurveTo(startX, startY, x, startY, x, startY + (y-startY)/2);
        ctx.bezierCurveTo(x, y, startX, y, startX, startY + (y-startY)/2); */
        //ctx2.moveTo(startPosition.x, startPosition.y);

        for (index = 0; index < coordinates.length; index++) {
            if (coordinates[index].s == true) {
                //console.log("inside");
                ctx.moveTo(coordinates[index].startx, coordinates[index].starty);
                ctx.lineTo(coordinates[index].x, coordinates[index].y);
            } else {
                if (index != coordinates.length - 1) {
                    ctx.moveTo(coordinates[index + 1].x, coordinates[index + 1].y);
                }

            }
        }

        ctx.strokeStyle = selectedColor;
        ctx.stroke();
        //ctx2.closePath();

        //ctx2.fill();

    }

    function drawText(coordinates) {
        //console.log("here");
        ctx.fillStyle = selectedColor;
        ctx.font = text_size + 'px sans-serif';
        for (index = 0; index < coordinates.length; index++) {
            ctx.fillText(coordinates[index].txt, coordinates[index].x - 4, coordinates[index].y - 4);
        }

    }




    function erase(coordinates) {


        //   ctx.globalCompositeOperation = 'destination-out';
        //   ctx.beginPath();
        //   ctx.lineWidth = marker_eraser_size;
        //
        //   for (index = 0; index < coordinates.length; index++) {
        //
        //     ctx.arc(coordinates[index].x, coordinates[index].y, parseInt(coordinates[index].size), 0, 2 * Math.PI);
        //     ctx.fill();
        //
        //     //ctx.beginPath();
        //     ctx.moveTo(coordinates[index].oldX, coordinates[index].oldY);
        //
        //     ctx.lineTo(coordinates[index].x, coordinates[index].y);
        //     ctx.stroke();
        //
        // }



        ctx.globalCompositeOperation = 'destination-out';

        ctx.beginPath();
        ctx.moveTo(coordinates[0].x, coordinates[0].y);
        // ctx.strokeStyle = selectedColor;
        ctx.lineWidth = marker_eraser_size;

        for (index = 1; index < coordinates.length; index++) {
            if (coordinates[index].s == true) {
                ctx.lineTo(coordinates[index].x, coordinates[index].y);
            } else {
                if (index != coordinates.length - 1) {
                    ctx.moveTo(coordinates[index + 1].x, coordinates[index + 1].y);
                }
            }
        }

        //ctx.closePath();
        ctx.stroke();

        // console.log(coordinates);




    }







    function clearWhiteboard() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }
</script>











<script>
    function showPdf(pdfUrl) {

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
                canvas.height = viewport.height;
                canvas.width = viewport.width;

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

            //document.getElementById('page_num').textContent = num;

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
        //document.getElementById('previous-page').addEventListener('click', onPrevPage);


        function onNextPage() {
            if (pageNum >= pdfDoc.numPages) {
                return;
            }
            pageNum++;
            queueRenderPage(pageNum);
        }
        //document.getElementById('next-page').addEventListener('click', onNextPage);


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

        //console.log(pdfUrl);

        pdfjsLib.getDocument('../presenter/' + pdfUrl).promise.then((doc) => {
            //console.log(doc);
            pdfDoc = doc;
            //document.getElementById('page_count').textContent = doc.numPages;
            renderPage(pageNum);

        });
    }


    function showPhoto(photoUrl) {
        canvas.style.backgroundImage = `url("${"../presenter/"+photoUrl}")`;
    }
</script>