<?php

declare(strict_types=1);

namespace PoP\Engine\Parser;

use PoP\ComponentModel\GraphQLParser\Parser\ExtendedParser;
use PoP\GraphQLParser\Parser\Ast\Directive;
use PoP\GraphQLParser\Parser\Ast\Document;
use PoP\GraphQLParser\Parser\Ast\LeafField;
use PoP\GraphQLParser\Parser\Ast\MetaDirective;
use PoP\GraphQLParser\Parser\ExtendedParserInterface;
use PoP\Root\AbstractTestCase;
use PoPBackbone\GraphQLParser\Exception\Parser\InvalidRequestException;
use PoPBackbone\GraphQLParser\Parser\Ast\Argument;
use PoPBackbone\GraphQLParser\Parser\Ast\ArgumentValue\InputList;
use PoPBackbone\GraphQLParser\Parser\Ast\ArgumentValue\Literal;
use PoPBackbone\GraphQLParser\Parser\Ast\ArgumentValue\Variable;
use PoPBackbone\GraphQLParser\Parser\Ast\ArgumentValue\VariableReference;
use PoPBackbone\GraphQLParser\Parser\Ast\Fragment;
use PoPBackbone\GraphQLParser\Parser\Ast\FragmentReference;
use PoPBackbone\GraphQLParser\Parser\Ast\InlineFragment;
use PoPBackbone\GraphQLParser\Parser\Ast\QueryOperation;
use PoPBackbone\GraphQLParser\Parser\Ast\RelationalField;
use PoPBackbone\GraphQLParser\Parser\Location;
use PoPBackbone\GraphQLParser\Parser\ParserTest;

class EnabledMetaDirectiveTest extends AbstractMetaDirectiveTest
{
    protected static function enableComposableDirectives(): bool
    {
        return true;
    }

    public function queryWithMetaDirectiveProvider()
    {
        return [
            [
                <<<GRAPHQL
                    query {
                        capabilities @forEach @upperCase
                    }
                GRAPHQL,
                new Document(
                    [
                        new QueryOperation(
                            '',
                            [],
                            [],
                            [
                                new LeafField(
                                    'capabilities',
                                    null,
                                    [],
                                    [
                                        new MetaDirective(
                                            'forEach',
                                            [
                                                // new Argument('if', new Literal(true, new Location(2, 28)), new Location(2, 24)),
                                            ],
                                            [
                                                new Directive('upperCase', [], new Location(2, 32)),
                                            ],
                                            new Location(2, 23)
                                        )
                                    ],
                                    new Location(2, 9)
                                ),
                            ],
                            new Location(1, 11)
                        )
                    ]
                ),
            ],
            [
                <<<GRAPHQL
                    query {
                        capabilities @forEach(affectDirectivesUnderPos: [1]) @upperCase
                    }
                GRAPHQL,
                new Document(
                    [
                        new QueryOperation(
                            '',
                            [],
                            [],
                            [
                                new LeafField(
                                    'capabilities',
                                    null,
                                    [],
                                    [
                                        new MetaDirective(
                                            'forEach',
                                            [
                                                new Argument('affectDirectivesUnderPos', new InputList([1], new Location(2, 57)), new Location(2, 31)),
                                            ],
                                            [
                                                new Directive('upperCase', [], new Location(2, 63)),
                                            ],
                                            new Location(2, 23)
                                        )
                                    ],
                                    new Location(2, 9)
                                ),
                            ],
                            new Location(1, 11)
                        )
                    ]
                ),
            ],
            [
                <<<GRAPHQL
                    query {
                        capabilities @forEach(affectDirectivesUnderPos: [1,2]) @upperCase @lowerCase
                    }
                GRAPHQL,
                new Document(
                    [
                        new QueryOperation(
                            '',
                            [],
                            [],
                            [
                                new LeafField(
                                    'capabilities',
                                    null,
                                    [],
                                    [
                                        new MetaDirective(
                                            'forEach',
                                            [
                                                new Argument('affectDirectivesUnderPos', new InputList([1, 2], new Location(2, 57)), new Location(2, 31)),
                                            ],
                                            [
                                                new Directive('upperCase', [], new Location(2, 65)),
                                                new Directive('lowerCase', [], new Location(2, 76)),
                                            ],
                                            new Location(2, 23)
                                        )
                                    ],
                                    new Location(2, 9)
                                ),
                            ],
                            new Location(1, 11)
                        )
                    ]
                ),
            ],
            [
                <<<GRAPHQL
                    query {
                        groupCapabilities @forEach @advancePointerInArrayOrObject(path: "group") @upperCase
                    }
                GRAPHQL,
                new Document(
                    [
                        new QueryOperation(
                            '',
                            [],
                            [],
                            [
                                new LeafField(
                                    'groupCapabilities',
                                    null,
                                    [],
                                    [
                                        new MetaDirective(
                                            'forEach',
                                            [],
                                            [
                                                new MetaDirective(
                                                    'advancePointerInArrayOrObject',
                                                    [
                                                        new Argument('path', new Literal('group', new Location(2, 74)), new Location(2, 67)),
                                                    ],
                                                    [
                                                        new Directive('upperCase', [], new Location(2, 83)),
                                                    ],
                                                    new Location(2, 37)
                                                )
                                            ],
                                            new Location(2, 28)
                                        )
                                    ],
                                    new Location(2, 9)
                                ),
                            ],
                            new Location(1, 11)
                        )
                    ]
                ),
            ],
            [
                <<<GRAPHQL
                    query {
                        groupCapabilities @forEach @advancePointerInArrayOrObject(path: "group") @upperCase @lowerCase
                    }
                GRAPHQL,
                new Document(
                    [
                        new QueryOperation(
                            '',
                            [],
                            [],
                            [
                                new LeafField(
                                    'groupCapabilities',
                                    null,
                                    [],
                                    [
                                        new MetaDirective(
                                            'forEach',
                                            [],
                                            [
                                                new MetaDirective(
                                                    'advancePointerInArrayOrObject',
                                                    [
                                                        new Argument('path', new Literal('group', new Location(2, 74)), new Location(2, 67)),
                                                    ],
                                                    [
                                                        new Directive('upperCase', [], new Location(2, 83)),
                                                    ],
                                                    new Location(2, 37)
                                                )
                                            ],
                                            new Location(2, 28)
                                        ),
                                        new Directive('lowerCase', [], new Location(2, 94)),
                                    ],
                                    new Location(2, 9)
                                ),
                            ],
                            new Location(1, 11)
                        )
                    ]
                ),
            ],
        ];
    }

    /**
     * @dataProvider failingQueryWithMetaDirectiveProvider
     */
    public function testFailingMetaDirectives(string $query)
    {
        $parser = $this->getParser();

        $this->expectException(InvalidRequestException::class);
        $parser->parse($query);

    }

    public function failingQueryWithMetaDirectiveProvider(): array
    {
        return [
            [
                <<<GRAPHQL
                    query {
                        capabilities @forEach(affectDirectivesUnderPos: [2]) @upperCase
                    }
                GRAPHQL,
            ],
            [
                <<<GRAPHQL
                    query {
                        capabilities @forEach(affectDirectivesUnderPos: [-2]) @upperCase
                    }
                GRAPHQL,
            ],
            [
                <<<GRAPHQL
                    query {
                        capabilities @forEach(affectDirectivesUnderPos: [1,2]) @upperCase
                    }
                GRAPHQL,
            ],
        ];
    }
}
