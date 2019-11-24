<?php

namespace WpComponents\Templates\Utilities;

use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\TemplateReferenceInterface;

/**
 * Custom file loader which appends .php if required
 */
class CustomFileLoader extends FilesystemLoader
{
    public function load(TemplateReferenceInterface $template)
    {
        $name = $template->get('name');

        if (empty(pathinfo($name, PATHINFO_EXTENSION)))
        {
            $template->set('name', "$name.php");
        }

        return parent::load($template);
    }
}
