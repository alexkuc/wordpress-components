<?php

namespace WpComponents\Templates\Utilities;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Helper\SlotsHelper;

use WpComponents\Templates\Utilities\CustomFileLoader;

/**
 * Concrete implementation of Symfony's templating component
 */
class TemplateEngine
{

    private $PhpEngine;
    private $FileSystemLoader;

    public function __construct()
    {
        $path = get_template_directory() . '/Templates/%name%';

        $this->FileSystemLoader = new CustomFileLoader($path);
        $this->PhpEngine = new PhpEngine(new TemplateNameParser(), $this->FileSystemLoader);

        $this->configureEngine();
    }

    private function configureEngine(): void
    {
        $this->PhpEngine->set(new SlotsHelper());
    }

    public function renderTemplate(string $name): void
    {
        echo $this->PhpEngine->render($name);
    }

}
