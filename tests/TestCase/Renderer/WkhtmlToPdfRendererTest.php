<?php
namespace Phauthentic\Test\TestCase\View;

use Phauthentic\Presentation\View\PdfView;
use PHPUnit\Framework\TestCase;

/**
 * WkhtmlToPdfRenderer
 */
class WkhtmlToPdfRendererTest extends TestCase
{
	public function testPdfGeneration()
	{
		$pdfView = new PdfView();
		$pdfRenderer = new \Phauthentic\Presentation\Renderer\WkhtmlToPdfRenderer();

		$result = $pdfRenderer->render($pdfView);

		var_dump($result);
		die();
	}
}
