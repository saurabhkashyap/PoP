<?php

declare(strict_types=1);

namespace PoPBackbone\GraphQLParser\Parser\Ast;

use PoPBackbone\GraphQLParser\Parser\Location;

class ShorthandMutationOperation extends MutationOperation
{
    public function __construct(
        /** @var FieldInterface[]|FragmentInterface[] */
        protected array $fieldOrFragmentReferences,
        Location $location,
    ) {
        parent::__construct('', [], [], $fieldOrFragmentReferences, $location);
    }  
}
