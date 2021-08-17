<?php

declare(strict_types=1);

namespace PoP\ComponentModel\ModuleProcessors;

abstract class AbstractQueryDataModuleProcessor extends AbstractModuleProcessor implements FilterDataModuleProcessorInterface
{
    use QueryDataModuleProcessorTrait;
}
