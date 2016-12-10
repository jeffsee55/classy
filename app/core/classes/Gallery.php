<?php

namespace Classy;

class Gallery
{
    protected $images;
    protected $columns;

    public function __construct($output = '', $atts, $instance)
    {
		$return = $output; // fallback

		$query_images_args = array(
		    'post_type'      => 'attachment',
		    'post_mime_type' => 'image',
			'post__in' 		 => explode(',', $atts['ids']),
		    'post_status'    => 'inherit',
		    'posts_per_page' => -1,
		);
		$query_images = new \WP_Query( $query_images_args );

		$images = array();
		foreach ( $query_images->posts as $image ) {
			$images[] = wp_get_attachment_image_src($image->ID, $atts['size']);
		}
        // 1 and 2 columns show up but 3 columns does not
        $this->columns = isset($atts['columns']) ? $atts['columns'] : '3';
        $this->images = $images;
    }

    public function display()
    {
    	$html = '<div class="columns flex-wrap gallery">';
    	if($this->columns == 1)
            $html .= $this->singleColumnImages();
    	if($this->columns == 2)
            $html .= $this->doubleColumnImages();
    	if($this->columns == 3)
            $html .= $this->tileImages();
    	$html .= '</div>';
    	return $html;
    }

    private function singleColumnImages()
    {
        $html = '';
    	foreach($this->images as $image) {
    		$html .= '<div class="column is-12"><div class="gallery-image" style="background-image: url(' . $image[0] . '); height: '. $image[2] . 'px"></div></div>';
    	}
        return $html;
    }

    private function doubleColumnImages()
    {
        $rows = array_chunk($this->images, 2);
        $html = '';
        foreach($rows as $row) {
            $height = min($row[0][2], $row[1][2]);
        	foreach($row as $image) {
        		$html .= '<div class="column is-6"><div class="gallery-image" style="background-image: url(' . $image[0] . '); height: '. $height . 'px"></div></div>';
        	}
        }
        return $html;
    }

    private function tileImages()
    {
        $images = $this->images;
        ob_start();
        ?>
        <div class="column is-12">
            <div class="gallery-tile tile is-ancestor">
              <div class="tile is-vertical is-8">
                <div class="tile">
                  <div class="tile is-parent is-vertical">
                    <article class="tile is-child" style="background-image: url(<?= $images[0][0]; ?>);">
                    </article>
                    <article class="tile is-child" style="background-image: url(<?= $images[1][0]; ?>);">
                    </article>
                  </div>
                  <div class="tile is-parent">
                    <article class="tile is-child" style="background-image: url(<?= $images[2][0]; ?>);">
                    </article>
                  </div>
                </div>
                <div class="tile is-parent">
                <article class="tile is-child" style="background-image: url(<?= $images[3][0]; ?>);">
                  </article>
                </div>
              </div>
              <div class="tile is-parent">
                <article class="tile is-child" style="background-image: url(<?= $images[4][0]; ?>);">
                </article>
              </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}
