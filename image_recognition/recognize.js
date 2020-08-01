window.onload = function()
{
	var processingImage = document.getElementById("sourceImage");
	var canvas = document.getElementById("grayscaleImage");
	canvas.width = processingImage.width;
	canvas.height = processingImage.height;
	var context = canvas.getContext("2d");

	context.drawImage(sourceImage, 0, 0, sourceImage.width, sourceImage.height);

	ConvertToGrayscale(processingImage, context);
}

function ConvertToGrayscale(img, ctx)
{
	var imgData = ctx.getImageData(0,0,img.width,img.height);
	var data = imgData.data;

	for(var i = 0; i < data.length; i += 4)
	{
		var r = data[i];
		var g = data[i+1];
		var b = data[i+2];
		var a = data[i+3];

		var average = r+g+b/3;

		data[i] = average;
		data[i+1] = average;
		data[i+2] = average;
		data[i+3] = a;
	}

	ctx.drawImage(img, 0, 0, img.width, img.height);
}