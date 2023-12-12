<?php

declare(strict_types=1);


namespace Framework;

class TemplateEngine
{
    public function __construct(private string $basepath)
    {
    }

    public function render(string $template, array $data = [])
    {
        extract($data, EXTR_SKIP);

        ob_start();
        include $this->resolve($template);
        // this content function gets all the content and data of the page before loading
        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }

    // this function returns the full path of the page to be included.
    public function resolve(string $path)
    {
        return "{$this->basepath}/{$path}";
    }
}
