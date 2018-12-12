<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\Renderer;

use Phauthentic\Presentation\View\ViewInterface;
use Twig_Environment;

/**
 * Twig Renderer
 */
class TwigRenderer implements RendererInterface
{
    /**
     * Twig
     *
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * Constructor
     *
     * @param \Twig_Environment
     */
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @inheritDoc
     */
    public function render(ViewInterface $render): string
    {
        $template = $this->twig->load($render->getTemplate());

        return $template->render($render->getViewVars());
    }
}
