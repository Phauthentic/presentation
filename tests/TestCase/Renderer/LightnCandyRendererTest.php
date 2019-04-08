<?php
declare(strict_types = 1);

namespace Phauthentic\Test\TestCase\View;

use Phauthentic\Presentation\Renderer\LightnCandyRenderer;
use Phauthentic\Presentation\View\View;
use PHPUnit\Framework\TestCase;

/**
 * NativePHPRendererTest
 */
class LightnCandyRendererTest extends TestCase
{
    /**
     * Fixture Root
     *
     * @var string
     */
    protected $fixtureRoot;

    /**
     * @inheritDoc
     */
    public function setUp()
    {
        parent::setUp();

        $this->fixtureRoot = FIXTURE_ROOT . DIRECTORY_SEPARATOR . 'mustache';
    }

    /**
     * testRender
     *
     * @return void
     */
    public function testRender(): void
    {
        $renderer = new LightnCandyRenderer($this->fixtureRoot, null);

        $view = new View();
        $view->setTemplate('hello');
        $view->setVar('username', 'Florian');

        $result = $renderer->render($view);
        $this->assertEquals("<h1>Hello Florian</h1>\n", $result);
    }
}
