<?php

/**
 * Image to ascii text converter
 *
 * This class will take an image and convert each pixel to a random ascii character. Color values for each pixel are maintained and passed
 * as a hex value to an in-line css style.
 *
 * Requires php 5 and the GD library.
 *
 * License:  image2ascii.class.php is free software: you can redistribute it and/or modify it under the terms of the
 * GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * image2ascii.class.php is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
 *
 * @author     Chris Sprague <chris@chaoscontrol.org>
 * @copyright  2012 Chris Sprague
 * @license    http://www.gnu.org/licenses/gpl.html GNU Public License
 * @version    0.1.0
 */
class image2ascii
{
    /**
     * Class Constructor
     *
     * Set amx height and width constraint
     *
     * @param int       $max_width      Max width of image
     * @param int       $max_height     Max height of image
     */
    public function __construct($max_width = 640, $max_height = 480)
    {
        $this->max_x = (int) $max_width;
        $this->max_y = (int) $max_height;
    }

    /**
     * Create Image Object
     *
     * Creates the image object using GD for the given mime type and adds an ASCII character in place of each pixel.
     *
     * @param string    $filename       Full path to image file
     * @param string    $mime           Abbreviated MIME type (jpeg, png, gif)
     * @return boolean|object
     */
    public function getAsciiOutput($filename, $mime)
    {
        $this->filename = $filename;
        $this->mime = $mime;

        switch ($this->mime) {
            case 'jpeg':
                $this->image = imagecreatefromjpeg($this->filename);
                break;

            case 'png':
                $this->image = imagecreatefrompng($this->filename);
                break;

            case 'gif':
                $this->image = imagecreatefromgif($this->filename);
                break;

            default:
                return FALSE;
                break;
        }

        $output = '';

        $height = $this->getImageHeight();
        $width = $this->getImageWidth();

        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x <= $width; $x++) {

                $rgb = @imagecolorat($this->image, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                if ($x == $width) {
                    $output .= '<br />';
                } else {
                    $output .= '<span style="color: rgb(' . $r . ', ' . $g . ', ' . $b . '); ">' . $this->getCharachter() . '</span>';
                }
            }
        }

        return $output;
    }

    /**
     * Get Character
     *
     * Returns a random array element
     *
     * @return string
     */
    protected function getCharachter()
    {
        $characters = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',
            '@','#','$','%','&','1','2','3','4','5','6','7','8','9','0');
        return $characters[rand(0, 40)];
    }

    /**
     * Get Image Height
     *
     * @return int
     */
    private function getImageHeight()
    {
        return imagesy($this->image);
    }

    /**
     * Get Image Width
     *
     * @return int
     */
    private function getImageWidth()
    {
        return imagesx($this->image);
    }

    /**
     * Check Size Restrictions
     *
     * Checks the image's dimensions against the maximum height and width values.
     *
     * @return boolean
     */
    protected function checkSizeRestrictions()
    {
        if ($this->getImageWidth() > $this->max_x) {
            return TRUE;
        }

        if ($this->getImageHeight() > $this->max_y) {
            return TRUE;
        }

        return FALSE;
    }
}
