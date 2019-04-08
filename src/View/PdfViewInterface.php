<?php
declare(strict_types=1);

namespace Phauthentic\Presentation\View;

/**
 * Interface for data transfer objects (DTOs) to pass the data that needs to be
 * rendered to the renderer
 */
interface PdfViewInterface extends ViewInterface
{
    const PAGE_SIZE_A4 = 'A4';

    const ORIENTATION_PORTRAIT = 'portrait';
    const ORIENTATION_LANDSCAPE = 'landscape';

    /**
     * Get/Set Page size.
     *
     * @param null|string $pageSize Page size to set
     * @return $this
     */
    public function setPageSize(?string $pageSize): PdfViewInterface;

    /**
     * Gets the page size
     *
     * @return string|null
     */
    public function getPageSize(): ?string;

    /**
     * Get/Set Orientation.
     *
     * @param null|string $orientation orientation to set
     * @return $this
     */
    public function setOrientation(?string $orientation): PdfViewInterface;

    /**
     * Gets the orientation
     *
     * @return string
     */
    public function getOrientation();

    /**
     * Get/Set Encoding.
     *
     * @param null|string $encoding encoding to set
     * @return $this
     */
    public function setEncoding(?string $encoding): PdfViewInterface;

    /**
     * Gets the encoding
     *
     * @return string|null
     */
    public function getEncoding(): ?string;
}
