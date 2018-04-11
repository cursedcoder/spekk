<?php

namespace Spekk\Visitor;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class CollectMethod extends NodeVisitorAbstract
{
    public function enterNode(Node $node)
    {
        if ($node instanceof Node\Expr\MethodCall
        && $node->var instanceof Node\Expr\Variable
        && $node->var->name === 'this') {
            dumpAst($node); die;
        }
    }
}
