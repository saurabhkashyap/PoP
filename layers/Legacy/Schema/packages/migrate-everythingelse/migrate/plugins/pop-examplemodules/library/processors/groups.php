<?php
namespace PoP\ExampleModules;
use PoP\ComponentModel\ComponentProcessors\AbstractComponentProcessor;
use PoPCMSSchema\Pages\Facades\PageTypeAPIFacade;

class ComponentProcessor_Groups extends AbstractComponentProcessor
{
    public final const COMPONENT_EXAMPLE_HOME = 'example-home';
    public final const COMPONENT_EXAMPLE_AUTHOR = 'example-author';
    public final const COMPONENT_EXAMPLE_TAG = 'example-tag';

    public function getComponentNamesToProcess(): array
    {
        return array(
            self::COMPONENT_EXAMPLE_HOME,
            self::COMPONENT_EXAMPLE_AUTHOR,
            self::COMPONENT_EXAMPLE_TAG,
        );
    }

    /**
     * @return \PoP\ComponentModel\Component\Component[]
     */
    public function getSubcomponents(\PoP\ComponentModel\Component\Component $component): array
    {
        $ret = parent::getSubcomponents($component);

        switch ($component->name) {
            case self::COMPONENT_EXAMPLE_HOME:
                $pageTypeAPI = PageTypeAPIFacade::getInstance();
                if ($pageTypeAPI->getHomeStaticPageID()) {
                    $ret[] = [ComponentProcessor_Dataloads::class, ComponentProcessor_Dataloads::COMPONENT_EXAMPLE_HOMESTATICPAGE];
                } else {
                    $ret[] = [ComponentProcessor_Layouts::class, ComponentProcessor_Layouts::COMPONENT_EXAMPLE_HOMEWELCOME];
                    $ret[] = [ComponentProcessor_Dataloads::class, ComponentProcessor_Dataloads::COMPONENT_EXAMPLE_LATESTPOSTS];
                }
                break;

            case self::COMPONENT_EXAMPLE_AUTHOR:
                $ret[] = [ComponentProcessor_Dataloads::class, ComponentProcessor_Dataloads::COMPONENT_EXAMPLE_AUTHORDESCRIPTION];
                $ret[] = [ComponentProcessor_Dataloads::class, ComponentProcessor_Dataloads::COMPONENT_EXAMPLE_AUTHORLATESTPOSTS];
                break;

            case self::COMPONENT_EXAMPLE_TAG:
                $ret[] = [ComponentProcessor_Dataloads::class, ComponentProcessor_Dataloads::COMPONENT_EXAMPLE_TAGDESCRIPTION];
                $ret[] = [ComponentProcessor_Dataloads::class, ComponentProcessor_Dataloads::COMPONENT_EXAMPLE_TAGLATESTPOSTS];
                break;
        }

        return $ret;
    }
}

