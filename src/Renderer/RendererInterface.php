<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\Renderer;

use Phauthentic\Presentation\View\ViewInterface;

/**
 * Renderer Interface
 */
interface RendererInterface
{
    /**
     * Renders something
     *
     * @param \Phauthentic\Presentation\View\ViewInterface $view View DTO
     * @return string
     */
    public function render(ViewInterface $view): string;
}
