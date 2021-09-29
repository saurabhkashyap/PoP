<?php

declare(strict_types=1);

namespace PoPSchema\Notifications\TypeResolvers\ObjectType;

use Symfony\Contracts\Service\Attribute\Required;
use PoP\ComponentModel\RelationalTypeDataLoaders\RelationalTypeDataLoaderInterface;
use PoP\ComponentModel\TypeResolvers\ObjectType\AbstractObjectTypeResolver;
use PoPSchema\Notifications\RelationalTypeDataLoaders\ObjectType\NotificationTypeDataLoader;

class NotificationObjectTypeResolver extends AbstractObjectTypeResolver
{
    protected NotificationTypeDataLoader $notificationTypeDataLoader;
    
    #[Required]
    public function autowireNotificationObjectTypeResolver(
        NotificationTypeDataLoader $notificationTypeDataLoader,
    ): void {
        $this->notificationTypeDataLoader = $notificationTypeDataLoader;
    }
    
    public function getTypeName(): string
    {
        return 'Notification';
    }

    public function getSchemaTypeDescription(): ?string
    {
        return $this->translationAPI->__('Notifications for the user', 'notifications');
    }

    public function getID(object $object): string | int | null
    {
        $notification = $object;
        return $notification->histid;
    }

    public function getRelationalTypeDataLoader(): RelationalTypeDataLoaderInterface
    {
        return $this->notificationTypeDataLoader;
    }
}
