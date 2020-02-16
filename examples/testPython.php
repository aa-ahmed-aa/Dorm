<?php
require_once('./vendor/autoload.php');

use Ahmedkhd\Dorm\Executor;

//python
$python_code = <<<'EOT'
print "Hello, Python2"
EOT;

$obj = new Executor("python2");
$comp = $obj->compile($python_code);
echo "Running : " . implode($comp) . "\n";
