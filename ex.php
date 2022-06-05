<?php

?>

<html>

<head>

	<script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.11/dist/cropper.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.11/dist/cropper.css" rel="stylesheet">

</head>

<body>


	<canvas id="testCanvas" width="600" height="450">
		Your browser does not support canvas.
	</canvas>

	<input type="file" id="fileInput" onchange="handleFileSelect()" />
	<input type="button" onclick="cropper.startCropping()" value="Start cropping" />
	<input type="button" onclick="cropper.getCroppedImageSrc()" value="Crop" />
	<input type="button" onclick="cropper.restore()" value="Restore" />

	<script>

		const cropper = new Cropper();
		
		// initialize cropper by providing it with a target canvas and a XY ratio (height = width * ratio)
		cropper.start(document.getElementById("testCanvas"), 1);

		function handleFileSelect() {
			// this function will be called when the file input below is changed
			var file = document.getElementById("fileInput").files[0]; // get a reference to the selected file

			var reader = new FileReader(); // create a file reader
			// set an onload function to show the image in cropper once it has been loaded
			reader.onload = function (event) {
				var data = event.target.result; // the "data url" of the image
				cropper.showImage(data); // hand this to cropper, it will be displayed
			};

			// this loads the file as a data url calling the function above once done
			reader.readAsDataURL(file);
		}
	</script>

</body>

</html>