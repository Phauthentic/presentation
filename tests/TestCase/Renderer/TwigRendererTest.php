<?php
declare(strict_types = 1);

namespace Phauthentic\Test\TestCase\View;

use Phauthentic\Presentation\Renderer\TwigRenderer;
use Phauthentic\Presentation\View\View;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * TwigRendererTest
 */
class TwigRendererTest extends TestCase
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
        $loader = new FilesystemLoader($this->fixtureRoot);
        $twig = new Environment($loader, [
            'cache' => sys_get_temp_dir(),
        ]);

        $renderer = new TwigRenderer($twig);

        $view = new View();
        $view->setTemplate('hello');
        $view->setVar('username', 'Florian');

        $result = $renderer->render($view);
        $this->assertEquals("<h1>Hello Florian</h1>\n", $result);
    }
}
