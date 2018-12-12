<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\Service\Service;

use Phauthentic\Presentation\Renderer\RendererInterface;
use Phauthentic\Presentation\View\ViewInterface;

/**
 * Render Service Interface
 */
interface RenderServiceInterface
{
    /**
     * Adds a renderer to a mime type
     *
     * @return void
     */
    public function addRenderer(string $outputType, RendererInterface $renderer): self;

    /**
     * Checks if the given mime type can be rendered as output
     *
     * @param string $mimeType Mime Type
     * @return bool
     */
    public function canRender(string $mimeType);

    /**
     * Renders the view to the response
     *
     * @param \Phauthentic\Presentation\Renderer\ViewInterface $view
     * @param string $outputType Type of response data to render
     * @return string
     */
    public function render(ViewInterface $view, ?string $outputType = 'html'): string;
}
