<?php declare(strict_types=1);

namespace Rector\Rector;

use PhpParser\Node;
use PhpParser\Node\Stmt\Expression;
use PhpParser\NodeTraverser;
use Rector\NodeTypeResolver\Node\Attribute;
use Rector\PhpParser\NodeVisitor\RemovedNodesCollector;
use Rector\PhpParser\NodeVisitor\RemovingNodeVisitor;

/**
 * This could be part of @see AbstractRector, but decopuling to trait
 * makes clear what code has 1 purpose.
 */
trait RemovingTrait
{
    /**
     * @var RemovedNodesCollector
     */
    private $removedNodesCollector;

    /**
     * @var NodeTraverser
     */
    private $removingNodeTraverser;

    /**
     * @required
     */
    public function setRemovingTraitDependencies(
        RemovedNodesCollector $removedNodesCollector,
        RemovingNodeVisitor $removingNodeVisitor
    ): void {
        $this->removedNodesCollector = $removedNodesCollector;

        $this->removingNodeTraverser = new NodeTraverser();
        $this->removingNodeTraverser->addVisitor($removingNodeVisitor);
    }

    public function removeNode(Node $node): void
    {
        if (! $node instanceof Expression && $node->getAttribute(Attribute::PARENT_NODE) instanceof Expression) {
            $node = $node->getAttribute(Attribute::PARENT_NODE);
        }

        $this->removedNodesCollector->addNode($node);
    }

    /**
     * @param Node[] $nodes
     * @return Node[]
     */
    public function removeFromNodes(array $nodes): array
    {
        return $this->removingNodeTraverser->traverse($nodes);
    }
}