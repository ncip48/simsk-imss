<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drag and Drop Example</title>
    <style>
        .container {
            position: relative;
            width: 595px;
            /* Width of A4 paper in pixels */
            height: 842px;
            /* Height of A4 paper in pixels */
            border: 1px solid #ccc;
        }

        .draggable {
            position: absolute;
        }
    </style>
</head>

<body>
    <div class="container" id="container">
        <img src="{{ asset('storage/temp_img/39702/0.jpg') }}" alt="Image 1" id="image1" class="draggable">
        <div id="image2Container" class="draggable" style="cursor: move;">
            <img src="{{ asset('storage/qr/avV8hmWEXq.png') }}" alt="Image 2" id="image2" class="draggable"
                width="80" height="80">
            <div id="resizeHandle" class="resize-handle"></div>
        </div>
    </div>

    <script>
        let active = false;
        let currentX;
        let currentY;
        let initialX;
        let initialY;
        let xOffset = 0;
        let yOffset = 0;

        const container = document.getElementById('container');
        const image2 = document.getElementById('image2');

        image2.addEventListener('mousedown', dragStart, false);
        image2.addEventListener('mouseup', dragEnd, false);
        image2.addEventListener('mousemove', drag, false);

        function dragStart(e) {
            initialX = e.clientX - xOffset;
            initialY = e.clientY - yOffset;

            if (e.target === image2) {
                active = true;
            }
        }

        function dragEnd() {
            initialX = currentX;
            initialY = currentY;

            active = false;
        }

        function drag(e) {
            if (active) {
                e.preventDefault();

                currentX = e.clientX - initialX;
                currentY = e.clientY - initialY;

                xOffset = currentX;
                yOffset = currentY;

                setTranslate(currentX, currentY, image2);

                console.log(currentX, currentY)
            }
        }

        function setTranslate(xPos, yPos, el) {
            el.style.transform = `translate3d(${xPos}px, ${yPos}px, 0)`;
        }

        function saveImage() {
            //log the x,y coordinates of the image
            console.log(image2.getBoundingClientRect().x);
            console.log(image2.getBoundingClientRect().y);
        }
    </script>

    <button id="btn" onclick="saveImage()">Save</button>

</body>

</html>
