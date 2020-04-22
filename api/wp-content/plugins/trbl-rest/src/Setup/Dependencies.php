<?php

namespace TRBLRest\Setup;

class Dependencies
{

    private $dependencies;
    private static $instance;

    private function __construct()
    {
        $this->dependencies = array();
        $this->dependencies[] = new Dependency('ACF', 'Advanced custom fields is not installed or activated. Please install it for this plugin to function properly.');
    }

    private function checkDependencies() : bool
    {
        $are_met = true;
        foreach ($this->dependencies as $dependency) {
            $are_met = $dependency->checkDependency();
        }
        return $are_met;
    }

    public static function areMet() : bool
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance->checkDependencies();
    }
}
