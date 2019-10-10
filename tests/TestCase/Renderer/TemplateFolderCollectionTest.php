<?php
declare(strict_types = 1);

namespace Phauthentic\Test\TestCase\View;

use Phauthentic\Presentation\Renderer\SimpleXMLRenderer;
use Phauthentic\Presentation\Renderer\TemplateFolderCollection;
use Phauthentic\Presentation\View\View;
use PHPUnit\Framework\TestCase;

/**
 * SimpleXMLRender
 */
class TemplateFolderCollectionTest extends TestCase
{
    /**
     * @inheritDoc
     */
    public function setUp()
    {
        parent::setUp();

        $this->fixtureRoot = FIXTURE_ROOT . DIRECTORY_SEPARATOR . 'mustache';
    }

    /**
     * testCollection
     */
    public function testCollection(): void {
        $collection = new TemplateFolderCollection([
            $this->fixtureRoot
        ]);

        foreach ($collection as $item) {
            var_dump($item);
        }
    }
}
