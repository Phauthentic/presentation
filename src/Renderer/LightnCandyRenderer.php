<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\Renderer;

use Phauthentic\Presentation\Renderer\Exception\MissingTemplateException;
use Phauthentic\Presentation\View\ViewInterface;
use LightnCandy\LightnCandy;
use Psr\Cache\CacheItemPoolInterface;

/**
 * php Lightncandy template engine adapter
 *
 * @link https://github.com/zordius/lightncandy
 */
class LightnCandyRenderer implements RendererInterface
{
    /**
     * Root folder for the template files
     *
     * @var string
     */
    protected $templateRoot;

    /**
     * @var \Psr\Cache\CacheItemPoolInterface
     */
    protected $cache;

    /**
     * Flags
     *
     * @var array
     */
    protected $flags = [];

    /**
     * Helpers
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor
     *
     * @param string $templateRoot Template Root
     * @param|null \Psr\Cache\CacheItemPoolInterface $cacheItemPool PSR Cache Item Pool
     */
    public function __construct(
        string $templateRoot,
        ?CacheItemPoolInterface $cacheItemPool
    ) {
        $this->templateRoot = $templateRoot;
        $this->cache = $cacheItemPool;
    }

    /**
     * Set flags
     *
     * @param array $flags Flags
     * @return $this
     */
    public function setFlags(array $flags): self
    {
        $this->flags = $flags;
    }

    /**
     * Sets the helpers
     *
     * @param array $helpers Helpers
     * @return $this
     */
    public function setHelpers(array $helpers)
    {
        $this->helpers = $helpers;

        return $this;
    }

    /**
     * @param string $name Name
     * @param mixed $helper
     * @return $this;
     */
    public function addHelper(string $name, $helper)
    {
        $this->helpers[$name] = $helper;

        return $this;
    }

    /**
     * Gets the template file from the view DTO object
     *
     * @param \Phauthentic\Presentation\Renderer\ViewInterface
     * @return string
     */
    public function getTemplateFile(ViewInterface $view): string
    {
        $path = $view->getTemplatePath();
        $path = Utility::sanitizePath($path);

        $template = $this->templateRoot . DIRECTORY_SEPARATOR . $path .  $view->getTemplate() . '.html';

        if (!is_file($template)) {
            throw new MissingTemplateException('Template file missing: ' . $template);
        }

        return $template;
    }

    /**
     * @inheritDoc
     */
    public function renderTemplate($template, $viewVars): string
    {
        $tmpDir = sys_get_temp_dir();
        $templateHash = hash_file('sha1', $template);
        $cachedTemplateFile = $tmpDir . DIRECTORY_SEPARATOR . sha1($template) . '-' . $templateHash;

        if (!file_exists($cachedTemplateFile)) {
            $templateString = file_get_contents($template);
            $phpTemplateString = LightnCandy::compile($templateString, [
                'flags' => $this->flags,
                'helpers' => $this->helpers
            ]);
            file_put_contents($cachedTemplateFile, '<?php ' . $phpTemplateString . '?>');
        }

        ob_start();
        $renderer = require $cachedTemplateFile;
        $content = $renderer($viewVars);
        ob_end_clean();

        return $content;
    }

    /**
     * @inheritDoc
     */
    public function render(ViewInterface $view): string
    {
        $template = $this->getTemplateFile($view);

        return $this->renderTemplate($template, $view->getViewVars());
    }
}
