<?php

namespace Composer\Installers;

class EancmsInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array(
        'modules' => 'app/{$name}/',
        'module' => 'app/Modules/{$name}/',
        'deep-module' => 'app/Modules/{$name}/'
    );

    /**
     * Format package name.
     *
     * For package type eancms-module, cut off a trailing '-plugin' if present.
     */
    public function inflectPackageVars(array $vars): array
    {

        if ($vars['type'] === 'eancms-modules') {
            return $this->inflectPluginVars($vars);
        }

        if ($vars['type'] === 'eancms-module') {
            return $this->inflectPluginVars($vars);
        }

        if ($vars['type'] === 'eancms-deep-module') {
            return $this->inflectPluginVarsDeepModule($vars);
        }

        return $vars;
    }

    /**
     * @param array<string, string> $vars
     * @return array<string, string>
     */
    protected function inflectPluginVars(array $vars): array
    {
        $vars['name'] = $this->pregReplace('/-module$/', '', $vars['name']);
        $vars['name'] = str_replace(array('-', '_'), ' ', $vars['name']);
        $vars['name'] = str_replace(' ', '', ucwords($vars['name']));

        return $vars;
    }

    protected function inflectPluginVarsDeepModule(array $vars): array
    {

        $name = $vars['name'];
        $ar = explode('-', $name);
        if (count($ar) == 1) {
            $vars['name'] = ucwords($ar[0]);
            return $vars;
        }

        $moduleName = '';
        for ($i = 1; $i < count($ar); $i++) {
            $moduleName .= ucwords($ar[$i]);
        }
        $vars['name'] = ucwords($ar[0]) . '/' . $moduleName;

        return $vars;
    }

}
