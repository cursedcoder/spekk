<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpParser\NodeDumper;

$dumper = new NodeDumper();

function dumpAst($ast)
{
    global $dumper;

    echo $dumper->dump($ast);
}

use Spekk\Spekk;

(new Spekk(__DIR__ . '/spec/Acme/TextEditorSpec.php'))->parse();
