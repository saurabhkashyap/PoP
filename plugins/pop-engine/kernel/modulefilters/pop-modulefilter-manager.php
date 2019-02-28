<?php
namespace PoP\Engine;

class ModuleFilterManager
{
    protected $selected_filter_name;
    protected $filters;

    // From the moment in which a module is not excluded, every module from then on must also be included
    protected $not_excluded_ancestor_module;
    protected $not_excluded_module_sets;
    protected $not_excluded_module_sets_as_string;

    // When targeting modules in pop-engine.php (eg: when doing ->get_dbobjectids()) those modules are already and always included, so no need to check for their ancestors or anything
    protected $neverExclude = false;

    public function __construct()
    {
        ModuleFilterManager_Factory::setInstance($this);

        $this->filters = array();
        add_action('init', array($this, 'init'));
    }

    public function getSelectedFilterName()
    {
        if ($selected = $_REQUEST[GD_URLPARAM_MODULEFILTER]) {

            // Validate that the selected filter exists
            if (in_array($selected, array_keys($this->filters))) {
                return $selected;
            }
        }

        return null;
    }

    public function init()
    {
        if ($selected = $this->getSelectedFilterName()) {
            $this->selected_filter_name = $selected;

            // Initialize only if we are intending to filter modules. This way, passing modulefilter=somewrongpath will return an empty array, meaning to not render anything
            $this->not_excluded_module_sets = $this->not_excluded_module_sets_as_string = array();
        }
    }

    public function getNotExcludedModuleSets()
    {

        // It shall be used for requestmeta.rendermodules, to know from which modules the client must start rendering
        return $this->not_excluded_module_sets;
    }

    public function add($filter)
    {
        $this->filters[$filter->getName()] = $filter;
    }

    protected function ancestorModuleNotExcluded()
    {
        return !is_null($this->not_excluded_ancestor_module);
    }

    public function neverExclude($neverExclude)
    {
        $this->neverExclude = $neverExclude;
    }

    public function excludeModule($module, &$props)
    {
        if ($this->selected_filter_name) {
            if ($this->neverExclude) {
                return false;
            }

            if ($this->ancestorModuleNotExcluded()) {
                return false;
            }

            return $this->filters[$this->selected_filter_name]->excludeModule($module, $props);
        }

        return false;
    }

    public function removeExcludedSubmodules($module, $submodules)
    {
        if ($this->selected_filter_name) {
            if ($this->neverExclude) {
                return $submodules;
            }

            return $this->filters[$this->selected_filter_name]->removeExcludedSubmodules($module, $submodules);
        }

        return $submodules;
    }

    /**
     * The `prepare` function advances the modulepath one level down, when interating into the submodules, and then calling `restore` the value goes one level up again
     */
    public function prepareForPropagation($module)
    {
        if ($this->selected_filter_name) {
            if (!$this->neverExclude && is_null($this->not_excluded_ancestor_module) && $this->excludeModule($module, $props) === false) {

                // Set the current module as the one which is not excluded.
                $module_path_manager = ModulePathManager_Factory::getInstance();
                $module_propagation_current_path = $module_path_manager->getPropagationCurrentPath();
                $module_propagation_current_path[] = $module;

                $this->not_excluded_ancestor_module = ModulePathManager_Utils::stringifyModulePath($module_propagation_current_path);

                // Add it to the list of not-excluded modules
                if (!in_array($this->not_excluded_ancestor_module, $this->not_excluded_module_sets_as_string)) {
                    $this->not_excluded_module_sets_as_string[] = $this->not_excluded_ancestor_module;
                    $this->not_excluded_module_sets[] = $module_propagation_current_path;
                }
            }

            $this->filters[$this->selected_filter_name]->prepareForPropagation($module);
        }
    }
    public function restoreFromPropagation($module)
    {
        if ($this->selected_filter_name) {
            if (!$this->neverExclude && !is_null($this->not_excluded_ancestor_module) && $this->excludeModule($module, $props) === false) {
                $module_path_manager = ModulePathManager_Factory::getInstance();
                $module_propagation_current_path = $module_path_manager->getPropagationCurrentPath();
                $module_propagation_current_path[] = $module;

                // If the current module was set as the one not excluded, then reset it
                if ($this->not_excluded_ancestor_module == ModulePathManager_Utils::stringifyModulePath($module_propagation_current_path)) {
                    $this->not_excluded_ancestor_module = null;
                }
            }

            $this->filters[$this->selected_filter_name]->restoreFromPropagation($module);
        }
    }
}

/**
 * Initialization
 */
new ModuleFilterManager();
