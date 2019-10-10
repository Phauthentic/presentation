<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\Renderer\Exception;

/**
 * Missing Template Exception
 */
class MissingTemplateException extends RendererException
{
    public static function missingFile(string $file ) {
        return new self('Template file missing: ' . $file);
    }
}
