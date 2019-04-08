<?php
declare(strict_types = 1);

namespace Phauthentic\Test\TestCase\View;

use Phauthentic\Presentation\Renderer\WkhtmlToPdfRenderer;
use Phauthentic\Presentation\View\PdfView;
use PHPUnit\Framework\TestCase;

/**
 * WkhtmlToPdfRendererTest
 */
class WkhtmlToPdfRendererTest extends TestCase
{
    /**
     * testRender
     *
     * @todo finish me
     * @return void
     */
    public function testRender(): void
    {
        $pdfView = new PdfView();
        $pdfRenderer = new WkhtmlToPdfRenderer();

        $result = $pdfRenderer->render($pdfView);
    }
}
