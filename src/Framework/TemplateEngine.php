<?php

declare(strict_types=1);


namespace Framework;

class TemplateEngine
{
    private array $globalTemplateData = [];

    // * 3. Construtor for the template engine with the basepath as the value based on the VIEW constant in paths.php (go to App.php)
    public function __construct(private string $basepath)
    {
    }

    public function render(string $template, array $data = [])
    {
        extract($data, EXTR_SKIP);
        extract($this->globalTemplateData, EXTR_SKIP);

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

    public function addGlobal(string $key, mixed $value)
    {
        $this->globalTemplateData[$key] = $value;
    }
}
