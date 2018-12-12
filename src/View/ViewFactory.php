<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\View;

/**
 * View Factory
 */
class ViewFactory implements ViewFactoryInterface
{
    public function buildView(): ViewInterface
    {
        return new View();
    }
}
