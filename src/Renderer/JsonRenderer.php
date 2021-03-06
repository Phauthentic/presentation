<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\Renderer;

use Phauthentic\Presentation\View\ViewInterface;

/**
 * Simple Json Renderer
 */
class JsonRenderer implements RendererInterface
{
    /**
     * @inheritDoc
     */
    public function render(ViewInterface $view): string
    {
        return json_encode([
            $view->viewVars()
        ]);
    }
}
