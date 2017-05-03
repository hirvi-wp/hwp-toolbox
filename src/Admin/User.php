<?php

namespace HWP\Toolbox\Admin;

class User
{
    public function disableSchemePicker()
    {
        if (is_admin()) {
            remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');
            add_action( 'personal_options', [$this, 'removePersonalOptions']);
        }
    }

    public function removePersonalOptions()
    {
        echo '<script type="text/javascript">
          jQuery(document).ready(function( $ ){
            $("#your-profile .form-table:first, #your-profile h2:first").remove();
          });
        </script>';
    }

}