<?php

declare(strict_types=1);

namespace PoPSchema\PostCategories\TypeDataLoaders;

use PoPSchema\PostCategories\ComponentContracts\PostCategoryAPISatisfiedContractTrait;
use PoPSchema\Categories\TypeDataLoaders\AbstractCategoryTypeDataLoader;

class PostCategoryTypeDataLoader extends AbstractCategoryTypeDataLoader
{
    use PostCategoryAPISatisfiedContractTrait;
}
