<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\Renderer;

use Phauthentic\Presentation\Renderer\Exception\MissingTemplateException;
use Phauthentic\Presentation\View\ViewInterface;

/**
 * A very simple native PHP renderer without dependencies
 *
 * It just takes a php file and includes it and makes the view vars available
 * for it.
 */
class NativePHPRenderer implements RendererInterface
{
    /**
     * Root folder for the template files
     *
     * @var string
     */
    protected $templateRoot;

    /**
     * Constructor
     *
     * @var string $templateRoot
     */
    public function __construct(string $templateRoot)
    {
        $this->templateRoot = $templateRoot;
    }

    /**
     * Gets the template file from the view DTO object
     *
     * @param \Phauthentic\Presentation\Renderer\ViewInterface
     * @return string
     */
    public function getTemplateFile(ViewInterface $view): string
    {
        $path = $view->templatePath();
        $path = Utility::sanitizePath($path);

        $template = $this->templateRoot . DIRECTORY_SEPARATOR . $path .  $view->template() . '.php';

        if (!is_file($template)) {
            throw MissingTemplateException::missingFile($template);
        }

        return $template;
    }

    /**
     * @inheritDoc
     */
    public function renderTemplate($template, $viewVars): string
    {
        ob_start();
        extract($viewVars, EXTR_OVERWRITE);
        require $template;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * @inheritDoc
     */
    public function render(ViewInterface $view): string
    {
        $template = $this->getTemplateFile($view);

        return $this->renderTemplate($template, $view->viewVars());
    }
}
