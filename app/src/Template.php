<?php

namespace Angorb\EnvironmentalSensor;

class Template
{
    protected const TEMPLATE_DIR = __DIR__ . '/../resources/templates';

    // Server paths //
    protected string $templateDir = '';
    protected static array $extensions = [
        '',
        '.php',
        '.tpl.php',
    ];

    // URL-relative resources //
    protected string $stylesheetDir = '/css';
    protected array $stylesheets = [];
    protected string $scriptDir = '/scripts';
    protected array $scripts = [];
    protected string $fontDir = '/fonts';
    protected array $fonts = [];

    public function setTemplateDir(string $path): void
    {
        if (!\is_dir($path)) {
            throw new \Exception('Template directory "' . $path . '" does not exist.');
        }

        $this->templateDir = $path;
    }

    public function render(string $template, ?array $data = \null): string
    {
        foreach (self::$extensions as $extension) {
            $path = $this->templateDir  . \DIRECTORY_SEPARATOR . $template . $extension;
            if (\file_exists($path)) {
                break;
            }
            unset($path);
        }

        return self::compileHtml($path, $data);
    }

    public static function renderStatic(string $template, ?array $data = \null): string
    {
        foreach (self::$extensions as $extension) {
            $path = self::TEMPLATE_DIR  . \DIRECTORY_SEPARATOR . $template . $extension;
            if (\file_exists($path)) {
                break;
            }
            unset($path);
        }

        return self::compileHtml($path, $data);
    }

    private static function compileHtml(?string $path, ?array $data = \null): string
    {
        if (!isset($path) || empty($path)) {
            throw new \Exception('Template file not found');
        }

        \ob_start();
        // TODO secure me
        if (isset($data) && !empty($data)) {
            extract($data);
        }
        require $path;
        return \ob_get_clean();
    }
}
