<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\PhpStan\Rule;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\InClassNode;
use PHPStan\Rules\Rule;

/**
 * @implements Rule<InClassNode>
 * @codeCoverageIgnore
 */
final class SuffixTraitsWithTraitRule implements Rule
{
    private const ERROR_MESSAGE = 'Trait name "%s" must be suffixed with "Trait"';

    public function getNodeType(): string
    {
        return InClassNode::class;
    }

    /**
     * @param InClassNode $node
     *
     * @return array<string>
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $classReflection = $node->getClassReflection();
        if (!$classReflection->isTrait()) {
            return [];
        }

        $shortClassName = (string) $node->getOriginalNode()->name;
        if (str_ends_with($shortClassName, 'Trait')) {
            return [];
        }

        return [sprintf(self::ERROR_MESSAGE, $shortClassName)];
    }
}
