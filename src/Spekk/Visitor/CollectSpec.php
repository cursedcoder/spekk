<?php

namespace Spekk\Visitor;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use Spekk\CodeTemplate;

class CollectSpec extends NodeVisitorAbstract
{
    private $templates = [];

    public function enterNode(Node $node)
    {
        if ($node instanceof Node\Stmt\ClassMethod && $this->isSpec($node->name)) {
            $template = new CodeTemplate();

            $template->specAst = $node;
            $template->specName = $this->getName($node->name);

            $this->templates[] = $template;
        }
    }

    public function getTemplates()
    {
        return $this->templates;
    }

    private function isSpec(Node\Identifier $identifier)
    {
        return 0 === strpos($identifier->name, 'it_')
            || 0 === strpos($identifier->name, 'its_');
    }

    private function getName(Node\Identifier $identifier)
    {
        return $identifier->name;
    }
}
