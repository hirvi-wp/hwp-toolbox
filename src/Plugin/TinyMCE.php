<?php

namespace HWP\Toolbox\Plugin;

class TinyMCE
{

    public function cleanClasses()
    {
        add_filter('tiny_mce_before_init', [$this, 'removeMiscClasses']);
    }

    public function removeMiscClasses($in)
    {
        $in['paste_preprocess'] = "function(pl,o){ o.content = o.content.replace(/p class=\"p[0-9]+\"/g,'p'); o.content = o.content.replace(/span class=\"s[0-9]+\"/g,'span'); }";
        return $in;
    }
}