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
     * @var array
     */
    protected $flags = [];

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
        $cachedTemplateFile = $tmpDir . DIRECTORY_SEPARATOR . $templateHash;

        if (!file_exists($cachedTemplateFile)) {
            $templateString = file_get_contents($template);
            $phpTemplateString = LightnCandy::compile($templateString, [
                'flags' => $this->flags,
                'helpers' => []
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
