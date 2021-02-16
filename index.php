<?php
// PHP assessment 

class ImageResize
{
 public $img_type;

 protected $source_image;

 protected $original_image_width; 
 protected $original_image_height; 

 
protected $new_image_width;
protected $new_image_height;

    protected $new_x = 0;
    protected $new_y = 0;

    protected $source_x;
    protected $source_y;

    protected $source_w;
    protected $source_h;

public function __construct($filename){


    if ($filename === null || empty($filename)) {
            throw new Exception('File does not exist');
        }
        else{
            
            $image_info = getimagesize($filename);
            $this->original_image_width = $image_info[0];
            $this->original_image_height = $image_info[1];
            $this->source_type = $image_info[2];
        }

        switch ($this->img_type) {
     
        case IMAGETYPE_JPEG:
            $this->source_image = $this->imageCreateJpegfromjpeg($filename);

            // set new width and height for image, maybe it has changed
            $this->original_image_width = imagesx($this->source_image);
            $this->original_image_height = imagesy($this->source_image);

            break;

        case IMAGETYPE_PNG:
            $this->source_image = imagecreatefrompng($filename);
            break;

        default:
            throw new Exception('Unsupported image type');
        }

        if (!$this->source_image) {
            throw new Exception('Could not load image');
        }

        return $this->resize($this->getSourceWidth(), $this->getSourceHeight());


}

 /**
     * get squared image according to the given width and height
     */

 public	function square_image($width, $height , $square_size = 250){
		
		if($width > $this->getSourceHeight()){
			$height = $square_size;
			$width = $height*($width/$height);
		}
		if($height > $this-> getSourceWidth()){
			$width = $square_size;
			$height = $width*($height/$width);
		}
		if( $this-> getSourceHeight() == $this-> getSourceWidth){
			$width = $square_size;
			$height = $square_size;
		}
		
		$width = round($width);
		$height = round($height);
	
		if($width>$height){
			$difference = $width-$height;
			$half_difference =  round($difference/2);
		}
		if($height>$width){
			$difference = $new_height-$new_width;
			$half_difference =  round($difference/2);
		}
 }

  /**
     * Resizes image according to the given width
     */

public function resizeToWidth($width)
    {
        $ratio  = $width / $this->getSourceWidth();
        $height = $this->getSourceHeight() * $ratio;

        $this->resize($width, $height);

        return $this;
    }

      /**
     * Resizes image according to the given width and height
     */

    public function crop($width, $height)
    {
      
            if ($width > $this->getSourceWidth()) {
                $width  = $this->getSourceWidth();
            }

            if ($height > $this->getSourceHeight()) {
                $height = $this->getSourceHeight();
            }

        $ratio_source = $this->getSourceWidth() / $this->getSourceHeight();
        $ratio_new = $width / $height;

        if ($ratio_new < $ratio_source) {
            $this->resizeToHeight($height);

            $excess_width = ($this->getnewWidth() - $width) / $this->getnewWidth() * $this->getSourceWidth();

            $this->source_w = $this->getSourceWidth() - $excess_width;
            $this->source_x = $this->getCropPosition($excess_width, $position);

            $this->new_image_width = $width;
        } else {
            $this->resizeToWidth($width);

            $excess_height = ($this->getnewHeight() - $height) / $this->getnewHeight() * $this->getSourceHeight();

            $this->source_h = $this->getSourceHeight() - $excess_height;
            $this->source_y = $this->getCropPosition($excess_height, $position);

            $this->new_image_height = $height;
        }

        return $this;
    }

    /**
     * Resizes image according to the given width and height
     */
    public function resize($width, $height)
    {
            if ($width > $this->getSourceWidth() || $height > $this->getSourceHeight()) {
                $width  = $this->getSourceWidth();
                $height = $this->getSourceHeight();
            }

        $this->source_x = 0;
        $this->source_y = 0;

        $this->new_image_width = $width;
        $this->new_image_height = $height;

        $this->source_w = $this->getSourceWidth();
        $this->source_h = $this->getSourceHeight();

        return $this;
    }

    public function getSourceHeight()
    {
        return $this->original_h;
    }


     /**
     * Gets source width
     *
     * @return integer
     */
    public function getSourceWidth()
    {
        return $this->original_w;
    }

    /**
     * Gets width of the newi image
     *
     * @return integer
     */
    public function getnewWidth()
    {
        return $this->new_image_width;
    }

    /**
     * Gets height of the new image
     * @return integer
     */
    public function getnewHeight()
    {
        return $this->new_image_height;
    }


}

?>