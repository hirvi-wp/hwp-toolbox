<?php

namespace HWP\Toolbox\Foundation;

class Media
{

    /**
     * Enable SVG Upload
     */
    public function enableSVG()
    {
        $wp_version = get_bloginfo('version');

        add_filter('upload_mimes', [$this, 'addSVGMime']);
        add_filter('wp_prepare_attachment_for_js', [$this, 'setDimensions'], 10, 3);
        add_action('admin_enqueue_scripts', [$this, 'adminStyles']);
        add_action('wp_head', [$this, 'publicStyles']);

        if ($wp_version < "4.7.3") {
            add_filter('wp_check_filetype_and_ext', [$this, 'disableRealMimeChecking'], 10, 4);
        }
    }

    /**
     * @param array $mimes
     * @return mixed
     */
    public function addSVGMime($mimes)
    {
        $mimes['svg'] = 'image/svg+xml';

        return $mimes;
    }

    /**
     * @param $response
     * @param $attachment
     * @param $meta
     * @return mixed
     */
    public function setDimensions($response, $attachment, $meta)
    {
        if ($response['mime'] == 'image/svg+xml' && empty($response['sizes'])) {
            $svg_file_path = get_attached_file($attachment->ID);
            $dimensions = $this->getDimensions($svg_file_path);

            $response['sizes'] = [
                'full' => [
                    'url'         => $response['url'],
                    'width'       => $dimensions->width,
                    'height'      => $dimensions->height,
                    'orientation' => $dimensions->width > $dimensions->height ? 'landscape' : 'portrait'
                ]
            ];
        }

        return $response;
    }

    public function getDimensions($svg)
    {
        $svg = simplexml_load_file($svg);
        $attributes = $svg->attributes();
        $width = (string) $attributes->width;
        $height = (string) $attributes->height;

        return (object) ['width' => $width, 'height' => $height];
    }

    public function adminStyles()
    {
        wp_add_inline_style('wp-admin', ".media .media-icon img[src$='.svg'] { width: auto; height: auto; }");
        wp_add_inline_style('wp-admin', "#postimagediv .inside img[src$='.svg'] { width: 100%; height: auto; }");
    }

    public function publicStyles()
    {
        echo "<style>.post-thumbnail img[src$='.svg'] { width: 100%; height: auto; }</style>";
    }

    public function disableRealMimeChecking($data, $file, $filename, $mimes)
    {
        $wp_filetype = wp_check_filetype($filename, $mimes);

        $ext = $wp_filetype['ext'];
        $type = $wp_filetype['type'];
        $proper_filename = $data['proper_filename'];

        return compact('ext', 'type', 'proper_filename');
    }

}