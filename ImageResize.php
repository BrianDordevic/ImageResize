<?php
function resizeImageSizeKeepAspectRatio($imageUrl, $maxWidth, $maxHeight, $savePath)
{
	$imageDimensions = getimagesize($imageUrl);
	$imageWidth = $imageDimensions[0];
	$imageHeight = $imageDimensions[1];
	$imageSize['width'] = $imageWidth;
	$imageSize['height'] = $imageHeight;
	
	if($imageWidth > $maxWidth || $imageHeight > $maxHeight)
	{
		if ( $imageWidth > $imageHeight ) {
	    	$imageSize['height'] = floor(($imageHeight/$imageWidth)*$maxWidth);
  			$imageSize['width']  = $maxWidth;
		} else {
			$imageSize['width']  = floor(($imageWidth/$imageHeight)*$maxHeight);
			$imageSize['height'] = $maxHeight;
		}
	}
	
	if ($imageDimensions['mime'] == "image/jpeg")
		$source = imagecreatefromjpeg($imageUrl);
	elseif ($imageDimensions['mime'] == "image/png")
		$source = imagecreatefrompng($imageUrl);
	elseif ($imageDimensions['mime'] == "image/gif")
		$source = imagecreatefromgif($imageUrl);
		
	$destination = imagecreatetruecolor($imageSize['width'], $imageSize['height']);
	imagecopyresampled($destination, $source, 0, 0, 0, 0, $imageSize['width'], $imageSize['height'], $imageWidth, $imageHeight);

	imagejpeg($destination, $savePath . "resized-" . time() . ".jpg", 100);
}
?>