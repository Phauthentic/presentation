<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\Renderer;

use Phauthentic\Presentation\View\ViewInterface;
use Cake\View\View as CakeView;

/**
 * CakePHP View Renderer
 */
class CakePHPRenderer implements RendererInterface
{
    /**
     * CakePHP View Object
     *
     * @var \Cake\View\View;
     */
    protected $cakeView;

    /**
     * Constructor
     *
     * @param \Cake\View\View $view CakePHP View Object
     */
    public function __construct(CakeView $view)
    {
        $this->cakeView = $view;
    }

    /**
     * @inheritDoc
     */
    public function render(ViewInterface $view) : string
    {
        return $this->cakeView
            ->setTemplatePath($view->getTemplatePath())
            ->setTemplate($view->getTemplate())
            ->set($view->getViewVars())
            ->render();
    }
}
