<?php
namespace Phauthentic\Test\TestCase\View;

use Phauthentic\Presentation\Service\RenderService;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseFactoryInterface;

/**
 * Render ServiceTest Test
 */
class RenderServiceTest extends TestCase
{

	public function testService() {
		$factoryMock = $this->getMockBuilder(ResponseFactoryInterface::class)
			->getMock();

		$service = new RenderService($factoryMock);
	}
}
