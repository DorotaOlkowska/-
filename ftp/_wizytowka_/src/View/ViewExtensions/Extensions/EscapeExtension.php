<?php

namespace App\View\ViewExtensions\Extensions;

use App\View\ViewExtensions\ViewExtension;

class EscapeExtension extends ViewExtension
{
    public function getFunctions()
    {
        return array(
            'escape' => array($this, 'escape')
        );
    }

    public function escape($string)
    {
        return htmlspecialchars(htmlentities($string));
    }
}