<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\View;

/**
 * View Factory Interface
 */
interface ViewFactoryInterface
{
    public function buildView(): ViewInterface;
}
