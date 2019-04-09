# Simple XML Renderer

```php
use Phauthentic\Presentation\Renderer\SimpleXMLRenderer;
use Phauthentic\Presentation\View\View;

$array = [
    'total_stud' => 500,
    0 => [
        'student' =>
            [
                'id' => 1,
                'name' => 'abc',
                'address' =>
                    [
                        'city' => 'Pune',
                        'zip' => 411006
                    ]
            ]
    ],
    1 => [
        'student' =>
            [
                'id' => 2,
                'name' => 'xyz',
                'address' =>
                    [
                        'city' => 'Mumbai',
                        'zip' => 400906
                    ]
            ]
    ]
];

$view = new View();
$view->setVars($array);

$render = new SimpleXMLRenderer();
$result = $render->render($view);

echo $result;
```

This will generate the output:

```xml
<?xml version="1.0"?>
<data>
	<total_stud>500</total_stud>
	<student>
		<id>1</id>
		<name>abc</name>
		<address>
			<city>Pune</city>
			<zip>411006</zip>
		</address>
	</student>
	<student>
		<id>2</id>
		<name>xyz</name>
		<address>
			<city>Mumbai</city>
			<zip>400906</zip>
		</address>
	</student>
</data>
```
