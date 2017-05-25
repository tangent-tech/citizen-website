<?php
/*
Please do NOT think this as an OOP object, I just use the class to group the related functions...
*/

if (!defined('IN_CMS'))
	die("huh?");

class imaging
{
	// Variables
	private $img_input;
	private $img_output;
	private $img_src;
	private $format;
	private $quality = 100;
	private $x_input;
	private $y_input;
	private $x_output;
	private $y_output;
	private $resize;
	private $watermark_path = null;
	private $watermark_position = 'center';

	// Set image
	public function set_img($img, $type) {
		// Find format
		//$ext = strtoupper(pathinfo($img, PATHINFO_EXTENSION));

		// JPEG image
//        if(is_file($img) && ($ext == "JPG" OR $ext == "JPEG"))
//        if(is_file($img) && $type == 'image/jpeg')
		if((is_file($img) && stristr($type, 'jpeg')) || (is_file($img) && stristr($type, 'jpg')))
		{

//            $this->format = $ext;
			$this->format = "JPG";
			$this->img_input = imagecreatefromjpeg($img);
			$this->img_src = $img;

			$exif = @exif_read_data($img);
			if(!empty($exif['Orientation'])) {
				switch($exif['Orientation']) {
					case 8:
						$this->img_input = imagerotate($this->img_input,90,0);
						break;
					case 3:
						$this->img_input = imagerotate($this->img_input,180,0);
						break;
					case 6:
						$this->img_input = imagerotate($this->img_input,-90,0);
						break;
				}
			}

		}

		// PNG image
//        elseif(is_file($img) && $ext == "PNG")
//        elseif(is_file($img) && $type == 'image/png')
		elseif(is_file($img) && stristr($type, 'png'))
		{

//            $this->format = $ext;
			$this->format = "PNG";
			$this->img_input = imagecreatefrompng($img);
			$this->img_src = $img;

		}

		// GIF image
//        elseif(is_file($img) && $ext == "GIF")
//        elseif(is_file($img) && $type == 'image/gif')
		elseif(is_file($img) && stristr($type, 'gif'))
		{

//            $this->format = $ext;
			$this->format = "GIF";
			$this->img_input = imagecreatefromgif($img);
			$this->img_src = $img;

		}

		// Get dimensions
		$this->x_input = imagesx($this->img_input);
		$this->y_input = imagesy($this->img_input);

	}

	// Set maximum image size (pixels)
	public function set_size($size = 100)
	{

		// Resize
//	        if(1>0 || ($this->x_input > $size && $this->y_input > $size) )
		if($this->x_input > $size  )
		{

			// Wide
			if($this->x_input >= $this->y_input)
			{

				$this->x_output = $size;
				$this->y_output = ($this->x_output / $this->x_input) * $this->y_input;

			}

			// Tall
			else
			{
				$this->x_output = $size;
				$this->y_output = ($this->x_output / $this->x_input) * $this->y_input;

//	                $this->y_output = $size;
//	                $this->x_output = ($this->y_output / $this->y_input) * $this->x_input;

			}

			// Ready
			$this->resize = TRUE;
		}

		// Don't resize
		else {
			$this->x_output = $this->x_input;
			$this->y_output = $this->y_input;
			$this->resize = FALSE; 
		}
	}

	public function set_watermark($src, $position) {
		if (@getimagesize(strval($src)) !== false) {
			$this->watermark_path = $src;
			$this->watermark_position = $position;
			return true;
		}
		else
			return false;
	}

	// Set image quality (JPEG only)
	public function set_quality($quality) {
		if(is_int($quality)) {
			$this->quality = $quality;
		}
	}

	private function image_logo (&$dst_image, $src_image, $dst_w, $dst_h, $src_w, $src_h, $position='bottom-left') {
		imagealphablending($dst_image,true);
		imagealphablending($src_image,true);
		if ($position == 'random') {
			$position = rand(1,8);
		}
		switch ($position) {
			case 'top-right':
			case 'right-top':
			case 1:
				imagecopy($dst_image, $src_image, ($dst_w-$src_w), 0, 0, 0, $src_w, $src_h);
			break;
			case 'top-left':
			case 'left-top':
			case 2:
				imagecopy($dst_image, $src_image, 0, 0, 0, 0, $src_w, $src_h);
			break;
			case 'bottom-right':
			case 'right-bottom':
			case 3:
				imagecopy($dst_image, $src_image, ($dst_w-$src_w), ($dst_h-$src_h), 0, 0, $src_w, $src_h);
			break;
			case 'bottom-left':
			case 'left-bottom':
			case 4:
				imagecopy($dst_image, $src_image, 0 , ($dst_h-$src_h), 0, 0, $src_w, $src_h);
			break;
			case 'center':
			case 5:
				imagecopy($dst_image, $src_image, (($dst_w/2)-($src_w/2)), (($dst_h/2)-($src_h/2)), 0, 0, $src_w, $src_h);
			break;
			case 'top':
			case 6:
				imagecopy($dst_image, $src_image, (($dst_w/2)-($src_w/2)), 0, 0, 0, $src_w, $src_h);
			break;
			case 'bottom':
			case 7:
				imagecopy($dst_image, $src_image, (($dst_w/2)-($src_w/2)), ($dst_h-$src_h), 0, 0, $src_w, $src_h);
			break;
			case 'left':
			case 8:
				imagecopy($dst_image, $src_image, 0, (($dst_h/2)-($src_h/2)), 0, 0, $src_w, $src_h);
			break;
			case 'right':
			case 9:
				imagecopy($dst_image, $src_image, ($dst_w-$src_w), (($dst_h/2)-($src_h/2)), 0, 0, $src_w, $src_h);
			break;
		}
	}

	// Save image
	public function save_img($path)
	{
		$this->img_output = imagecreatetruecolor($this->x_output, $this->y_output);
		imagealphablending($this->img_output, false);
		imagesavealpha($this->img_output,true);
		$transparent = imagecolorallocatealpha($this->img_output, 255, 255, 255, 127);
		imagefilledrectangle($this->img_output, 0, 0, $this->x_output, $this->y_output, $transparent);

		if($this->watermark_path != null) {
			$WaterMarkFileInfo = getimagesize($this->watermark_path);
			$watermark = imagecreatefrompng($this->watermark_path);

			imagecopyresampled($this->img_output, $this->img_input, 0, 0, 0, 0, $this->x_output, $this->y_output, $this->x_input, $this->y_input);				
//				$TmpImage = imagecreatetruecolor($WaterMarkFileInfo[0], $WaterMarkFileInfo[1]);
//	        	imagecopyresampled($TmpImage, $this->img_input, 0, 0, 0, 0, $WaterMarkFileInfo[0], $WaterMarkFileInfo[1], $this->x_input, $this->y_input);
			$this->image_logo($this->img_output, $watermark, $this->x_output, $this->y_output, $WaterMarkFileInfo[0], $WaterMarkFileInfo[1], $this->watermark_position);
//	        	imagecopyresampled($this->img_output, $TmpImage, 0, 0, 0, 0, $this->x_output, $this->y_output, $WaterMarkFileInfo[0], $WaterMarkFileInfo[1]);
			@imagedestroy($watermark);
		}
		else {
			imagecopyresampled($this->img_output, $this->img_input, 0, 0, 0, 0, $this->x_output, $this->y_output, $this->x_input, $this->y_input);
		}

		// Save JPEG
		if($this->format == "JPG" || $this->format == "JPEG") {
			imagejpeg($this->img_output, $path, $this->quality);
		}

		// Save PNG
		elseif($this->format == "PNG") {
			imagepng($this->img_output, $path);
		}

		// Save GIF
		elseif($this->format == "GIF") {
			imagegif($this->img_output, $path);
		}
	}

	// Get width
	public function get_width() {
		return $this->x_input;
	}

	// Get height
	public function get_height() {
		return $this->y_input;
	}

	// Clear image cache
	public function clear_cache() {
		@imagedestroy($this->img_input);
		@imagedestroy($this->img_output);
	}

}