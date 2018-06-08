<?php

function imgThumbGen($srcFilePath, $destFoldPath, $thmbHW) {
    //This function will generate SQUARE thumbnail with specified thmbHeightWidth even if original image is rectangle;
    //Original image will be resized and then cropped, NOT JUST FITTED to square!
    //$srcFilePath = Your Original Source Image
    //$destFoldPath = "/Users/andrey/Sites/tmp2/"; /*Your Destination Folder */
    //$thmbHW = the side of generated thumbnail (Height == Width)

    $what = getimagesize($srcFilePath);
    $smallestDimension = (($what[0] < $what[1]) ? $what[0] : $what[1]); //Check what smaller - width or height and get smallest
    $file_name = basename($srcFilePath);/* Name of the Image File*/
    $ext   = pathinfo($file_name, PATHINFO_EXTENSION);

    /* Adding image name _thumb for thumbnail image */
    $file_name = basename($file_name, ".$ext") . '_thumb.' . $ext;

    switch(strtolower($what['mime']))
    {
        case 'image/png':
            $img = imagecreatefrompng($srcFilePath);
            $new = imagecreatetruecolor($thmbHW,$thmbHW);
            imagecopyresized($new,$img, 0, 0, ($what[0]-$smallestDimension)/2, ($what[1]-$smallestDimension)/2, $thmbHW, $thmbHW, $smallestDimension, $smallestDimension);
            imagepng($new,$destFoldPath.$file_name, 5);
            imagedestroy($new);
            return ($destFoldPath.$file_name);
        case 'image/jpeg':
            $img = imagecreatefromjpeg($srcFilePath);
            $new = imagecreatetruecolor($thmbHW,$thmbHW);
            imagecopyresized($new,$img, 0, 0, ($what[0]-$smallestDimension)/2, ($what[1]-$smallestDimension)/2, $thmbHW, $thmbHW, $smallestDimension, $smallestDimension);
            imagejpeg($new,$destFoldPath.$file_name, 90);
            imagedestroy($new);
            return ($destFoldPath.$file_name);
        case 'image/gif':
            $img = imagecreatefromgif($srcFilePath);
            $new = imagecreatetruecolor($thmbHW,$thmbHW);
            imagecopyresized($new,$img, 0, 0, ($what[0]-$smallestDimension)/2, ($what[1]-$smallestDimension)/2, $thmbHW, $thmbHW, $smallestDimension, $smallestDimension);
            imagegif($new,$destFoldPath.$file_name);
            imagedestroy($new);
            return ($destFoldPath.$file_name);
        default: return (null);
    }
}

//Using example:
$a = '/Users/andrey/Sites/tmp2/ea8ce01d226d.jpg';
$b = '/Users/andrey/Sites/tmp2/';
imgThumbGen($a, $b, 150);