<?php
declare(strict_types=1);

namespace Phauthentic\Presentation\View;

/**
 * Interface for data transfer objects (DTOs) to pass the data that needs to be
 * rendered to the renderer
 */
interface PdfViewInterface extends ViewInterface
{
	/**
	 * Get/Set Page size.
	 *
	 * @param null|string $pageSize Page size to set
	 * @return $this
	 */
	public function setPageSize(?string $pageSize): PdfViewInterface;

	/**
	 * Get/Set Orientation.
	 *
	 * @param null|string $orientation orientation to set
	 * @return $this
	 */
	public function setOrientation(?string $orientation): PdfViewInterface;

	/**
	 * Get/Set Encoding.
	 *
	 * @param null|string $encoding encoding to set
	 * @return $this
	 */
	public function setEncoding(?string $encoding): PdfViewInterface;
}
