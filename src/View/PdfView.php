<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\View;

/**
 * Abstract Pdf
 */
class PdfView extends View implements PdfViewInterface
{
    /**
     * Html to be rendered
     *
     * @var string
     */
    protected $html = '';

    /**
     * Page size of the pdf
     *
     * @var string
     */
    protected $pageSize = self::PAGE_SIZE_A4;

    /**
     * Orientation of the pdf
     *
     * @var string
     */
    protected $orientation = self::ORIENTATION_PORTRAIT;

    /**
     * Encoding
     *
     * @var string
     */
    protected $encoding = 'UTF-8';

    /**
     * Footer HTML
     *
     * @var array
     */
    protected $footer = ['left' => null, 'center' => null, 'right' => null];

    /**
     * Header HTML
     *
     * @var array
     */
    protected $header = ['left' => null, 'center' => null, 'right' => null];

    /**
     * Bottom margin in mm
     *
     * @var number
     */
    protected $marginBottom = null;

    /**
     * Left margin in mm
     *
     * @var number
     */
    protected $marginLeft = null;

    /**
     * Right margin in mm
     *
     * @var number
     */
    protected $marginRight = null;

    /**
     * Top margin in mm
     *
     * @var number
     */
    protected $marginTop = null;

    /**
     * Title of the document
     *
     * @var string
     */
    protected $title = null;

    /**
     * Javascript delay before rendering document in milliseconds
     *
     * @var int
     */
    protected $delay = null;

    /**
     * Window status required before rendering document
     *
     * @var string
     */
    protected $windowStatus = null;

    /**
     * Flag that tells if we need to pass it through crypto
     *
     * @var bool
     */
    protected $protect = false;

    /**
     * User password, used with crypto
     *
     * @var string
     */
    protected $userPassword = null;

    /**
     * Owner password, used with crypto
     *
     * @var string
     */
    protected $ownerPassword = null;

    /**
     * Permissions that are allowed, used with crypto
     *
     * false: none
     * true: all
     * array: List of permissions that are allowed
     *
     * @var mixed
     */
    protected $allow = false;

    /**
     * Available permissions
     *
     * @var array
     */
    protected $availablePermissions = [
        'print',
        'degraded_print',
        'modify',
        'assembly',
        'copy_contents',
        'screen_readers',
        'annotate',
        'fill_in',
    ];

    /**
     * Constructor
     *
     * @param array $config Pdf configs to use
     */
    public function __construct($config = [])
    {
        $options = [
            'pageSize',
            'orientation',
            'margin',
            'title',
            'encoding',
            'protect',
            'userPassword',
            'ownerPassword',
            'permissions',
            'cache',
            'delay',
            'windowStatus',
        ];
        foreach ($options as $option) {
            if (isset($config[$option])) {
                $this->{$option}($config[$option]);
            }
        }
    }

    /**
     * Get/Set Html.
     *
     * @param null|string $html Html to set
     * @return mixed
     */
    public function getHtml(): string
    {
        return $this->html;
    }

    /**
     * Sets the HTML to render
     *
     * @param string $html HTML
     * @return
     */
    public function setHtml($html = null): PdfViewInterface
    {
        $this->html = $html;

        return $this;
    }

    /**
     * Set Page size.
     *
     * @param null|string $pageSize Page size to set
     * @return \Phauthentic\Presentation\View\PdfViewInterface
     */
    public function setPageSize(?string $pageSize ): PdfViewInterface
    {
        $this->pageSize = $pageSize;

        return $this;
    }

    /**
     * Gets the page size
     *
     * @return string|null
     */
    public function getPageSize(): ?string
    {
        return $this->pageSize;
    }

    /**
     * Gets the orientation
     *
     * @return string
     */
    public function getOrientation(): ?string
    {
        return $this->orientation;
    }

    /**
     * Get/Set Orientation.
     *
     * @param null|string $orientation orientation to set
     * @return mixed
     */
    public function setOrientation(?string $orientation): PdfViewInterface
    {
        if ($orientation === null) {
            return $this->orientation;
        }
        $this->orientation = $orientation;

        return $this;
    }

    /**
     * Get/Set Encoding.
     *
     * @param null|string $encoding encoding to set
     * @return $this
     */
    public function setEncoding(?string $encoding): PdfViewInterface
    {
        $this->encoding = $encoding;

        return $this;
    }

    /**
     * Gets the encoding
     *
     * @return string|null
     */
    public function getEncoding(): ?string
    {
        return $this->encoding;
    }

    /**
     * Get/Set footer HTML.
     *
     * @param null|string $left left side footer
     * @param null|string $center center footer
     * @param null|string $right right side footer
     * @return mixed
     */
    public function footer($left = null, $center = null, $right = null)
    {
        if ($left === null && $center === null && $right === null) {
            return $this->footer;
        }

        if (is_array($left)) {
            extract($left, EXTR_IF_EXISTS);
        }

        $this->footer = compact('left', 'center', 'right');

        return $this;
    }

    /**
     * Get/Set header HTML.
     *
     * @param null|string $left left side header
     * @param null|string $center center header
     * @param null|string $right right side header
     * @return mixed
     */
    public function header($left = null, $center = null, $right = null)
    {
        if ($left === null && $center === null && $right === null) {
            return $this->header;
        }

        if (is_array($left)) {
            extract($left, EXTR_IF_EXISTS);
        }

        $this->header = compact('left', 'center', 'right');

        return $this;
    }

    /**
     * Gets the margins
     *
     * @return array
     */
    public function getMargin(): array
    {
        return [
            'bottom' => $this->marginBottom,
            'left' => $this->marginLeft,
            'right' => $this->marginRight,
            'top' => $this->marginTop,
        ];
    }

    /**
     * Get/Set page margins.
     *
     * Several options are available
     *
     * Array format
     * ------------
     * First param can be an array with the following options:
     * - bottom
     * - left
     * - right
     * - top
     *
     * Set margin for all borders
     * --------------------------
     * $bottom is set to a string
     * Leave all other parameters empty
     *
     * Set margin for horizontal and vertical
     * --------------------------------------
     * $bottom value will be set to bottom and top
     * $left value will be set to left and right
     *
     * @param null|string|array $bottom bottom margin, or array of margins
     * @param null|string $left left margin
     * @param null|string $right right margin
     * @param null|string $top top margin
     * @return mixed
     */
    public function setMargin($bottom = null, $left = null, $right = null, $top = null)
    {
        if (is_array($bottom)) {
            extract($bottom, EXTR_IF_EXISTS);
        }

        if ($bottom && $left === null && $right === null && $top === null) {
            $left = $right = $top = $bottom;
        }

        if ($bottom && $top === null) {
            $top = $bottom;
        }

        if ($left && $right === null) {
            $right = $left;
        }

        $this->marginBottom($bottom);
        $this->marginLeft($left);
        $this->marginRight($right);
        $this->marginTop($top);

        return $this;
    }

    /**
     * Get/Set bottom margin.
     *
     * @param null|string $margin margin to set
     * @return mixed
     */
    public function marginBottom($margin = null)
    {
        if ($margin === null) {
            return $this->marginBottom;
        }
        $this->marginBottom = $margin;

        return $this;
    }

    /**
     * Get/Set left margin.
     *
     * @param null|string $margin margin to set
     * @return mixed
     */
    public function marginLeft($margin = null)
    {
        if ($margin === null) {
            return $this->marginLeft;
        }
        $this->marginLeft = $margin;

        return $this;
    }

    /**
     * Get/Set right margin.
     *
     * @param null|string $margin margin to set
     * @return mixed
     */
    public function marginRight($margin = null)
    {
        if ($margin === null) {
            return $this->marginRight;
        }
        $this->marginRight = $margin;

        return $this;
    }

    /**
     * Get/Set top margin.
     *
     * @param null|string $margin margin to set
     * @return mixed
     */
    public function marginTop($margin = null)
    {
        if ($margin === null) {
            return $this->marginTop;
        }
        $this->marginTop = $margin;

        return $this;
    }

    /**
     * Set document title
     *
     * @param null|string $title title to set
     * @return mixed
     */
    public function setTitle(?string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Gets the title
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     *
     */
    public function getJsDelay()
    {
        return $this->delay();
    }

    /**
     * Get/Set javascript delay.
     *
     * @param null|int $delay delay to set in milliseconds
     * @return mixed
     */
    public function delay($delay = null)
    {
        if ($delay === null) {
            return $this->delay;
        }
        $this->delay = $delay;

        return $this;
    }

    /**
     * Set the required window status for rendering
     *
     * Waits until the status is equal to the string before rendering the pdf
     *
     * @param null|string $status status to set as string
     * @return \Phauthentic\Presentation\View\PdfViewInterface
     */
    public function setWindowStatus(?string $status): PdfViewInterface
    {
        $this->windowStatus = $status;

        return $this;
    }

    /**
     * Gets the window status
     *
     * @return null|string
     */
    public function getWindowStatus(): ?string
    {
        return $this->windowStatus;
    }

    /**
     * Get/Set protection.
     *
     * @param null|bool $protect True or false
     * @return mixed
     */
    public function protect($protect = null)
    {
        if ($protect === null) {
            return $this->protect;
        }
        $this->protect = $protect;

        return $this;
    }

    /**
     * Get/Set userPassword
     *
     * The user password is used to control who can open the PDF document.
     *
     * @param null|string $password password to set
     * @return mixed
     */
    public function userPassword($password = null)
    {
        if ($password === null) {
            return $this->userPassword;
        }
        $this->userPassword = $password;

        return $this;
    }

    /**
     * Get/Set ownerPassword.
     *
     * The owner password is used to control who can modify, print, manage the PDF document.
     *
     * @param null|string $password password to set
     * @return mixed
     */
    public function ownerPassword($password = null)
    {
        if ($password === null) {
            return $this->ownerPassword;
        }
        $this->ownerPassword = $password;

        return $this;
    }

    /**
     * Get/Set permissions.
     *
     * all: allow all permissions
     * none: allow no permissions
     * array: list of permissions that are allowed
     *
     * @param null|bool|array $permissions Permissions to set
     * @throws \Cake\Core\Exception\Exception
     * @return mixed
     */
    public function permissions($permissions = null)
    {
        if (!$this->protect()) {
            return $this;
        }

        if ($permissions === null) {
            return $this->allow;
        }

        if (is_string($permissions) && $permissions == 'all') {
            $permissions = true;
        }

        if (is_string($permissions) && $permissions == 'none') {
            $permissions = false;
        }

        if (is_array($permissions)) {
            foreach ($permissions as $permission) {
                if (!in_array($permission, $this->availablePermissions)) {
                    throw new Exception(sprintf('Invalid permission: %s', $permission));
                }

                if (!$this->crypto()->permissionImplemented($permission)) {
                    throw new Exception(sprintf('Permission not implemented in crypto engine: %s', $permission));
                }
            }
        }

        $this->allow = $permissions;

        return $this;
    }
}
