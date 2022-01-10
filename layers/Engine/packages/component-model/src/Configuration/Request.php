<?php

declare(strict_types=1);

namespace PoP\ComponentModel\Configuration;

use PoP\ComponentModel\Constants\DatabasesOutputModes;
use PoP\ComponentModel\Constants\DataOutputModes;
use PoP\ComponentModel\Constants\DataSourceSelectors;
use PoP\ComponentModel\Constants\Outputs;
use PoP\ComponentModel\Constants\Params;
use PoP\Definitions\Configuration\Request as DefinitionsRequest;

class Request
{
    public static function getOutput(): string
    {
        $output = strtolower($_REQUEST[Params::OUTPUT] ?? '');
        $outputs = [
            Outputs::HTML,
            Outputs::JSON,
        ];
        if (!in_array($output, $outputs)) {
            return Outputs::HTML;
        }
        return $output;
    }

    public static function getDataStructure(): string
    {
        return strtolower($_REQUEST[Params::DATASTRUCTURE] ?? '');
    }

    public static function getMangledValue(): string
    {
        return DefinitionsRequest::isMangled() ? '' : DefinitionsRequest::URLPARAMVALUE_MANGLED_NONE;
    }

    /**
     * @return string[]
     */
    public static function getActions(): array
    {
        return isset($_REQUEST[Params::ACTIONS]) ? array_map('strtolower', $_REQUEST[Params::ACTIONS]) : [];
    }

    public static function getScheme(): string
    {
        return strtolower($_REQUEST[Params::SCHEME] ?? '');
    }

    public static function getDataSourceSelector(): string
    {
        $dataSourceSelector = strtolower($_REQUEST[Params::DATA_SOURCE] ?? '');
        $allDataSourceSelectors = [
            DataSourceSelectors::ONLYMODEL,
            DataSourceSelectors::MODELANDREQUEST,
        ];
        if (!in_array($dataSourceSelector, $allDataSourceSelectors)) {
            return DataSourceSelectors::MODELANDREQUEST;
        }
        return $dataSourceSelector;
    }

    public static function getDataOutputMode(): string
    {
        $dataOutputMode = strtolower($_REQUEST[Params::DATAOUTPUTMODE] ?? '');
        $dataOutputModes = [
            DataOutputModes::SPLITBYSOURCES,
            DataOutputModes::COMBINED,
        ];
        if (!in_array($dataOutputMode, $dataOutputModes)) {
            return DataOutputModes::SPLITBYSOURCES;
        }
        return $dataOutputMode;
    }

    public static function getDBOutputMode(): string
    {
        $dbOutputMode = strtolower($_REQUEST[Params::DATABASESOUTPUTMODE] ?? '');
        $dbOutputModes = array(
            DatabasesOutputModes::SPLITBYDATABASES,
            DatabasesOutputModes::COMBINED,
        );
        if (!in_array($dbOutputMode, $dbOutputModes)) {
            return DatabasesOutputModes::SPLITBYDATABASES;
        }
        return $dbOutputMode;
    }
    
    
    
    /**
     * Indicates the version constraint for all fields/directives in the query
     */
    public static function getVersionConstraint(): ?string
    {
        return $_REQUEST[Params::VERSION_CONSTRAINT] ?? null;
    }

    /**
     * Indicates the version constraints for specific fields in the schema
     */
    public static function getVersionConstraintsForFields(): ?array
    {
        return $_REQUEST[Params::VERSION_CONSTRAINT_FOR_FIELDS] ?? null;
    }

    /**
     * Indicates the version constraints for specific directives in the schema
     */
    public static function getVersionConstraintsForDirectives(): ?array
    {
        return $_REQUEST[Params::VERSION_CONSTRAINT_FOR_DIRECTIVES] ?? null;
    }
}
