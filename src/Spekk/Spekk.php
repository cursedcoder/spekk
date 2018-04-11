<?php

namespace Spekk;

use PhpParser\NodeDumper;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\ParserFactory;
use Spekk\Visitor\CollectMethod;
use Spekk\Visitor\CollectSpec;

class Spekk
{
    private $data;

    public function __construct($path)
    {
        $this->data = file_get_contents($path);
    }

    public function parse()
    {
        $parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP7);

        $ast = $parser->parse($this->data);
        $ast = $this->traverse($ast, new NameResolver());

        $this->traverse($ast, $collect = new CollectSpec());
        $this->traverse($this->templateToAst($collect->getTemplates()), new CollectMethod());

        $dumper = new NodeDumper();

        echo $dumper->dump($this->templateToAst($collect->getTemplates()));

        return $ast;
    }

    private function templateToAst(array $templates)
    {
        return array_map(function ($item) {
            return $item->specAst;
        }, $templates);
    }

    private function traverse(array $ast, $visitor)
    {
        $traverser = new NodeTraverser();
        $traverser->addVisitor($visitor);

        return $traverser->traverse($ast);
    }
}
