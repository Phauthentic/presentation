<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\Renderer;

/**
 * Utility
 */
class Utility
{
    /**
     * Sanitizes the template path
     *
     * @param string $path
     * @return string
     */
    public static function sanitizePath(string $path): string
    {
        if (DIRECTORY_SEPARATOR === '\\') {
            return str_replace('/', '\\', $path);
        }

        return str_replace('\\', '/', $path);
    }
}
