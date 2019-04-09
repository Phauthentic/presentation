<?php
declare(strict_types = 1);

namespace Phauthentic\Test\TestCase\View;

use Phauthentic\Presentation\Renderer\Utility;
use Phauthentic\Presentation\Renderer\WkhtmlToPdfRenderer;
use Phauthentic\Presentation\View\PdfView;
use PHPUnit\Framework\TestCase;

/**
 * UtilityTest
 */
class UtilityTest extends TestCase
{
    /**
     * testSanitizePath
     *
     * @todo finish me
     * @return void
     */
    public function testSanitizePath(): void
    {
        $result = Utility::sanitizePath('/test\bar');

        if (DIRECTORY_SEPARATOR === '/') {
            $this->assertEquals('/test/bar', $result);
        } else {
            $this->assertEquals('\test\bar', $result);
        }
    }
}
