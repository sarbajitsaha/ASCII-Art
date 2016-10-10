<?php
    function convertImageAscii($path, $scale)
    {
        $chars = "$@B%8&WM#*oahkbdpqwmZO0QLCJUYXzcvunxrjft/\\|()1{}[]?-_+~<>i!lI;:,\"^`'. ";
        //70 chars from black to white
        $chars = str_split($chars);
        $c_size = count($chars);

        $res = array();

        $info = new SplFileInfo($path);
        if($info->getExtension()=="png")
        {
        	$im = imagecreatefrompng($path);
        }
        else if($info->getExtension()=="jpeg" || $info->getExtension()=="jpg")
        {
        	$im = imagecreatefromjpeg($path);
        }
        else
        {
        	echo "Only png, jpeg and jpg formats are supported. Exiting";
        	exit(1);
        }

        if($im==null)
        {
        	echo "Image file not valid";
        	exit(1);
        }
        if($scale!=-1)
            $im = imagescale($im, $scale); //to preserve aspect ratio dont give height
        if(!$im)
        {
            return false;
        }
        //convert to grayscale
        $size = getimagesize($path);
        if($scale!=-1)
        {
            $width = $scale;
            $height = (int)(($scale*$size[1])/$size[0]);
        }
        else
        {
                list($width, $height) = $size;
        }

        $str = "";
        for($i = 0; $i<$height; $i++)
        {
            for($j = 0; $j<$width; $j++)
            {
                $rgb = imagecolorat($im, $j, $i);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                $bw = (0.21*$r) + (0.72*$g) + (0.07*$b);

                $char = $chars[(int)($bw/3.7)]; //255/70 = 3.64
                $str.= $char;
            }
            $str.=PHP_EOL;
        }

        return $str;

    }
 ?>
