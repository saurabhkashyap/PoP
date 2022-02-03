<?php

declare(strict_types=1);

namespace PoP\GraphQLParser\Spec\Library\Validator;

use PoP\GraphQLParser\Exception\Parser\InvalidRequestException;
use PoP\GraphQLParser\FeedbackMessageProviders\GraphQLSpecErrorMessageProvider;
use PoP\GraphQLParser\Spec\Execution\Context;
use PoP\GraphQLParser\Spec\Execution\ExecutableDocument;
use PoP\GraphQLParser\Spec\Parser\Ast\Argument;
use PoP\GraphQLParser\Spec\Parser\Ast\ArgumentValue\Variable;
use PoP\GraphQLParser\Spec\Parser\Ast\ArgumentValue\VariableReference;
use PoP\GraphQLParser\Spec\Parser\Ast\Document;
use PoP\GraphQLParser\Spec\Parser\Ast\Fragment;
use PoP\GraphQLParser\Spec\Parser\Ast\FragmentReference;
use PoP\GraphQLParser\Spec\Parser\Ast\LeafField;
use PoP\GraphQLParser\Spec\Parser\Ast\QueryOperation;
use PoP\GraphQLParser\Spec\Parser\Ast\RelationalField;
use PoP\GraphQLParser\Spec\Parser\Location;
use PoP\Root\AbstractTestCase;

class RequestValidatorTest extends AbstractTestCase
{
    protected function getGraphQLSpecErrorMessageProvider(): GraphQLSpecErrorMessageProvider
    {
        return $this->getService(GraphQLSpecErrorMessageProvider::class);
    }

    /**
     * @dataProvider invalidRequestProvider
     */
    public function testInvalidRequests(ExecutableDocument $executableDocument)
    {
        $this->expectException(InvalidRequestException::class);
        $exceptionMessages = [
            'fragment-not-defined' => $this->getGraphQLSpecErrorMessageProvider()->getMessage(GraphQLSpecErrorMessageProvider::E_5_5_2_1, 'reference'),
            'fragment-not-defined-2' => $this->getGraphQLSpecErrorMessageProvider()->getMessage(GraphQLSpecErrorMessageProvider::E_5_5_2_1, 'reference2'),
            'fragment-not-used' => $this->getGraphQLSpecErrorMessageProvider()->getMessage(GraphQLSpecErrorMessageProvider::E_5_5_1_4, 'reference2'),
            'fragment-name-duplicated' => $this->getGraphQLSpecErrorMessageProvider()->getMessage(GraphQLSpecErrorMessageProvider::E_5_5_1_1, 'reference2'),
            'variable-not-defined' => $this->getGraphQLSpecErrorMessageProvider()->getMessage(GraphQLSpecErrorMessageProvider::E_5_8_3, 'test'),
            'variable-value-not-set' => $this->getGraphQLSpecErrorMessageProvider()->getMessage(GraphQLSpecErrorMessageProvider::E_5_8_5, 'test'),
        ];
        $this->expectExceptionMessage($exceptionMessages[$this->dataName()] ?? '');
        $executableDocument->validateAndInitialize();
    }

    public function invalidRequestProvider()
    {
        $context = new Context(null, [
            'test' => 'ponga',
            'test2' => 'chonga',
            'test3' => 'conga',
        ]);
        $variable1 = new Variable('test', 'Int', false, false, true, new Location(1, 1));
        $variable1->setContext($context);
        $variable2 = new Variable('test2', 'Int', false, false, true, new Location(1, 1));
        $variable2->setContext($context);
        $variable3 = new Variable('test3', 'Int', false, false, true, new Location(1, 1));
        $variable3->setContext($context);
        $requiredVariable = new Variable('test', 'Int', true, false, true, new Location(1, 1));
        $requiredVariable->setContext($context);

        return [
            'fragment-not-defined' => [
                (new ExecutableDocument(
                    new Document([
                        new QueryOperation(
                            'saranga',
                            [],
                            [],
                            [
                                new RelationalField('test', null, [], [
                                    new FragmentReference('reference', new Location(1, 1))
                                ], [], new Location(1, 1)),
                                new FragmentReference('reference', new Location(1, 1))
                            ],
                            new Location(1, 1)
                        )]),
                    new Context()
                )),
            ],
            'fragment-not-defined-2' => [
                (new ExecutableDocument(
                    new Document([
                        new QueryOperation(
                            'saranga',
                            [],
                            [],
                            [
                                new RelationalField('test', null, [], [
                                    new FragmentReference('reference', new Location(1, 1)),
                                    new FragmentReference('reference2', new Location(1, 1)),
                                ], [], new Location(1, 1))
                            ],
                            new Location(1, 1)
                        )
                        ], [
                        new Fragment('reference', 'TestType', [], [], new Location(1, 1))
                    ]),
                    new Context()
                )),
            ],
            'fragment-not-used' => [
                (new ExecutableDocument(
                    new Document([
                        new QueryOperation(
                            'saranga',
                            [],
                            [],
                            [
                                new RelationalField('test', null, [], [
                                    new FragmentReference('reference', new Location(1, 1)),
                                ], [], new Location(1, 1))
                            ],
                            new Location(1, 1)
                        )
                        ], [
                            new Fragment('reference', 'TestType', [], [], new Location(1, 1)),
                            new Fragment('reference2', 'TestType', [], [], new Location(1, 1))
                        ]),
                    new Context()
                )),
            ],
            'fragment-name-duplicated' => [
                (new ExecutableDocument(
                    new Document([
                        new QueryOperation(
                            'saranga',
                            [],
                            [],
                            [
                                new RelationalField('test', null, [], [
                                    new FragmentReference('reference2', new Location(1, 1)),
                                ], [], new Location(1, 1))
                            ],
                            new Location(1, 1)
                        )
                        ], [
                            new Fragment('reference2', 'TestType', [], [], new Location(1, 1)),
                            new Fragment('reference2', 'TestType', [], [], new Location(1, 1))
                        ]),
                    new Context()
                )),
            ],
            'variable-not-defined' => [
                (new ExecutableDocument(
                    new Document([
                        new QueryOperation(
                            'saranga',
                            [],
                            [],
                            [
                                new RelationalField(
                                    'test',
                                    null,
                                    [
                                        new Argument('test', new VariableReference('test', null, new Location(1, 1)), new Location(1, 1))
                                    ],
                                    [
                                        new LeafField('test', null, [], [], new Location(1, 1))
                                    ],
                                    [],
                                    new Location(1, 1)
                                )
                            ],
                            new Location(1, 1)
                        )
                        ]),
                    new Context()
                )),
            ],
            'variable-value-not-set' => [
                (new ExecutableDocument(
                    new Document([
                        new QueryOperation(
                            'saranga',
                            [],
                            [],
                            [
                                new RelationalField('test', null, [
                                    new Argument('test', new VariableReference('test', $requiredVariable, new Location(1, 1)), new Location(1, 1)),
                                ], [
                                    new LeafField('test', null, [], [], new Location(1, 1))
                                ], [], new Location(1, 1))
                            ],
                            new Location(1, 1)
                        )
                        ]),
                    new Context()
                )),
            ]
        ];
    }
}
