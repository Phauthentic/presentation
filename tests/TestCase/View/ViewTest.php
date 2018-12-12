<?php
namespace Phauthentic\Test\TestCase\View;

use Phauthentic\Presentation\View\View;
use PHPUnit\Framework\TestCase;

/**
 * View Test
 */
class ViewTest extends TestCase
{
    /**
     * testView
     *
     * @return void
     */
    public function testView(): void
    {
        $view = (new View())
            ->setVar('foo', 'bar')
            ->setVars([
                'one' => 'onevar',
                'two' => 'twovar'
            ])
            ->setTemplatePath('Posts')
            ->setTemplate('view.php');

        $expected = [
            'foo' => 'bar',
            'one' => 'onevar',
            'two' => 'twovar'
        ];
        $this->assertEquals($expected, $view->getViewVars());
    }
}
