<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\Renderer;

use Phauthentic\Presentation\View\ViewInterface;

/**
 * View Renderer Interface
 */
interface ViewRendererInterface
{
    /**
     * Renders something
     *
     * @param \Phauthentic\Presentation\View\ViewInterface $view View DTO
     * @return string
     */
    public function renderView(ViewInterface $view): string;
}
