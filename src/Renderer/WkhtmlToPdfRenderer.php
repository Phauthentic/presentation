<?php
declare(strict_types = 1);

namespace Phauthentic\Presentation\Renderer;

use InvalidArgumentException;
use Phauthentic\Presentation\View\PdfViewInterface;
use Phauthentic\Presentation\View\ViewInterface;
use RuntimeException;

/**
 * Twig Renderer
 */
class WkhtmlToPdfRenderer
{
	/**
	 * Binary
	 *
	 * @var string
	 */
	protected $binary = '/usr/bin/wkhtmltopdf';

	/**
	 *
	 */
	protected $isWindowsEnvironment = false;

	/**
	 * Cwd for phps proc_open
	 */
	protected $cwd = null;

	public function setBinary(string $binary): self
	{
		if (!file_exists($binary)) {
			throw new InvalidArgumentException('Binary %s does not exist');
		}

		if (!is_executable($binary)) {
			throw new RuntimeException('%s not a binary or can not be executed');
		}

		$this->binary = $binary;

		return $this;
	}

    /**
     * Constructor
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
        $this->cwd = sys_get_temp_dir();
        $this->isWindowsEnvironment = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

        if ($this->isWindowsEnvironment) {
            $this->setBinary('C:/Progra~1/wkhtmltopdf/bin/wkhtmltopdf.exe');
        }
    }

    /**
     * Generates Pdf from html
     *
     * @throws \Cake\Core\Exception\Exception
     * @return string Raw PDF data
     * @throws \Exception If no output is generated to stdout by wkhtmltopdf.
     */
    public function render(PdfViewInterface $view)
    {
        $command = $this->buildCommand($view);
        $content = $this->exec($command, $view->getHtml());

        if (!empty($content['stdout'])) {
            return $content['stdout'];
        }

        if (!empty($content['stderr'])) {
            throw new Exception(sprintf(
                'System error "%s" when executing command "%s". ' .
                'Try using the binary provided on http://wkhtmltopdf.org/downloads.html',
                $content['stderr'],
                $command
            ));
        }

        throw new Exception("WKHTMLTOPDF didn't return any data");
    }

    /**
     * Execute the WkHtmlToPdf commands for rendering pdfs
     *
     * @param string $cmd the command to execute
     * @param string $input Html to pass to wkhtmltopdf
     * @return array the result of running the command to generate the pdf
     */
    protected function exec($cmd, $input)
    {
        $result = ['stdout' => '', 'stderr' => '', 'return' => ''];

        $proc = proc_open($cmd, [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes, $this->cwd);
        fwrite($pipes[0], $input);
        fclose($pipes[0]);

        $result['stdout'] = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $result['stderr'] = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        $result['return'] = proc_close($proc);

        return $result;
    }

    /**
     * Get the command to render a pdf
     *
     *
     * @return string the command for generating the pdf
     */
    protected function buildCommand(PdfViewInterface $pdfView): string
    {
        $options = [
            'quiet' => true,
            'print-media-type' => true,
            'orientation' => $pdfView->getOrientation(),
            'page-size' => $pdfView->getPageSize(),
            'encoding' => $pdfView->getEncoding(),
            'title' => $pdfView->getTitle(),
            'javascript-delay' => $pdfView->getJsDelay(),
            'window-status' => $pdfView->getWindowStatus(),
        ];

        $margin = $pdfView->getMargin();
        foreach ($margin as $key => $value) {
            if ($value !== null) {
                $options['margin-' . $key] = $value . 'mm';
            }
        }
        $options = array_merge($options, (array)$this->options);

        if ($this->isWindowsEnvironment) {
            $command = '"' . $this->binary . '"';
        } else {
            $command = $this->binary;
        }

        foreach ($options as $key => $value) {
            if (empty($value)) {
                continue;
            } elseif (is_array($value)) {
                foreach ($value as $k => $v) {
                    $command .= sprintf(' --%s %s %s', $key, escapeshellarg($k), escapeshellarg($v));
                }
            } elseif ($value === true) {
                $command .= ' --' . $key;
            } else {
                $command .= sprintf(' --%s %s', $key, escapeshellarg($value));
            }
        }
        $footer = $pdfView->footer();
        foreach ($footer as $location => $text) {
            if ($text !== null) {
                $command .= " --footer-$location \"" . addslashes($text) . "\"";
            }
        }

        $header = $pdfView->header();
        foreach ($header as $location => $text) {
            if ($text !== null) {
                $command .= " --header-$location \"" . addslashes($text) . "\"";
            }
        }
        $command .= " - -";

        if ($this->isWindowsEnvironment) {
            $command = '"' . $command . '"';
        }

        return $command;
    }
}
