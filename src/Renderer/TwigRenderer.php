<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\Renderer;

use Phauthentic\Presentation\View\ViewInterface;
use Twig\Environment;

/**
 * Twig Renderer
 */
class TwigRenderer extends AbstractBaseRenderer implements RendererInterface
{
    /**
     * Twig
     *
     * @var \Twig\Environment
     */
    protected $twig;

    /**
     * Extension
     *
     * @var string
     */
    protected $extension = 'html';

    /**
     * Constructor
     *
     * @param \Twig_Environment
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Gets the Twig instance
     *
     * @return \Twig\Environment
     */
    public function getTwig(): Environment
    {
        return $this->twig;
    }

    /**
     * @inheritDoc
     */
    public function render(ViewInterface $render): string
    {
        $template = $this->twig->load($render->getTemplate() . '.' . $this->getTemplateExtension());

        return $template->render($render->getViewVars());
    }
}
