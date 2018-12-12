<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\View;

use Psr\Container\ContainerInterface;

/**
 * Helper Aware View Interface
 */
interface HelperAwareViewInterface
{
    /**
     * Gets the helper container
     *
     * @return \Psr\Container\ContainerInterface
     */
    public function helpers(): ContainerInterface;
}
