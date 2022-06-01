<?php

declare(strict_types=1);

namespace PoP\ComponentModel\Checkpoints;

use PoP\Root\Feedback\FeedbackItemResolution;

interface CheckpointInterface
{
    /**
     * @return array<array>
     */
    public function getCheckpointsToProcess(): array;

    /**
     * @return FeedbackItemResolution|null `null` if successful, or FeedbackItemResolution with a descriptive error message and code otherwise
     */
    public function validateCheckpoint(): ?FeedbackItemResolution;
}
