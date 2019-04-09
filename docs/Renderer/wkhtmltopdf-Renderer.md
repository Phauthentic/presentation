# wkhtmltopdf Renderer

[wkhtmltopdf](https://wkhtmltopdf.org/) is the most easy and reliable way of rendering pdfs from a web application. All the pdf libraries written in php have their flaws and quirks. LaTeX is complicated to set up and use. So wkthmltopdf is the best compromise.

wkhtmltopdf still requires you to install it and to tell the renderer where it can find the binary. Please check the official documentation on how to install it.

```php
use Phauthentic\Renderer\WkhtmlToPdfRenderer;

$renderer = new WkhtmlToPdfRenderer();
$renderer->setBinary('/path/to/wkhtmltopdf');
```
