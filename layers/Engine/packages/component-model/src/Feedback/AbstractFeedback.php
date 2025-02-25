<?php

declare(strict_types=1);

namespace PoP\ComponentModel\Feedback;

use PoP\Root\Feedback\FeedbackItemResolution;

abstract class AbstractFeedback implements FeedbackInterface
{
    public function __construct(
        protected FeedbackItemResolution $feedbackItemResolution,
    ) {
    }

    public function getFeedbackItemResolution(): FeedbackItemResolution
    {
        return $this->feedbackItemResolution;
    }
}
