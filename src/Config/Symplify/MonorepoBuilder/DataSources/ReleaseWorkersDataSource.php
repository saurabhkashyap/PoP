<?php

declare(strict_types=1);

namespace PoP\PoP\Config\Symplify\MonorepoBuilder\DataSources;

use PoP\PoP\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker\GuardOnDefaultBranchReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\PushNextDevReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\PushTagReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetCurrentMutualConflictsReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetCurrentMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetNextMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\TagVersionReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateBranchAliasReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateReplaceReleaseWorker;

class ReleaseWorkersDataSource
{
    /**
     * @return string[]
     */
    public function getReleaseWorkerClasses(): array
    {
        return [
            GuardOnDefaultBranchReleaseWorker::class,
            UpdateReplaceReleaseWorker::class,
            SetCurrentMutualConflictsReleaseWorker::class,
            SetCurrentMutualDependenciesReleaseWorker::class,
            TagVersionReleaseWorker::class,
            PushTagReleaseWorker::class,
            SetNextMutualDependenciesReleaseWorker::class,
            UpdateBranchAliasReleaseWorker::class,
            PushNextDevReleaseWorker::class,
        ];
    }
}
