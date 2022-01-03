<?php

namespace Composer\Installers;

class EancmsInstaller extends BaseInstaller
{
    /** @var array<string, string> */
    protected $locations = array(
        'module' => 'Modules/{$name}/'
    );

    /**
     * Format package name.
     *
     * For package type eancms-module, cut off a trailing '-plugin' if present.
     */
    public function inflectPackageVars(array $vars): array
    {
        if ($vars['type'] === 'eancms-module') {
            return $this->inflectPluginVars($vars);
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

}
