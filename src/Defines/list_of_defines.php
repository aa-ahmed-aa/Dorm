<?php
if (!defined('ACCEPTED')) {
    define('ACCEPTED', 0);
}
if (! defined('WRONG_ANSWER')) {
    define('WRONG_ANSWER', 1);
}
if (!defined('TIME_LIMIT_EXCEEDED')) {
    define('TIME_LIMIT_EXCEEDED', 2);
}
if (!defined('COMPILER_ERROR')) {
    define('COMPILER_ERROR', 3);
}
if (!defined('CPP')) {
    define('CPP', 'cpp');
}
if (!defined('C')) {
    define('C', 'c');
}
if (!defined('JAVA')) {
    define('JAVA', 'java');
}
if (!defined('PYTHON')) {
    define('PYTHON', 'python');
}
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('TEST_COMPILER_DIR')) {
    define('TEST_COMPILER_DIR', __DIR__ . DS . '..' . DS . '..' . DS . 'tests' . DS . 'testDir');
}
