<?php

declare(strict_types=1);

namespace PoP\ComponentModel\AttachableExtensions;

interface AttachableExtensionManagerInterface
{
    public function attachExtensionToClass(string $attachableClass, string $group, AttachableExtensionInterface $attachableExtension): void;
    /**
     * @return AttachableExtensionInterface[]
     */
    public function getAttachedExtensions(string $attachableClass, string $group): array;
}
