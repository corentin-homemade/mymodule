<?php

namespace PrestaShop\Module\MyModule\Form;

use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\ConfigurationInterface;

/**
 * Configuration is used to save data to configuration table and retrieve from it.
 */
final class MyModuleConfigurationTextDataConfiguration implements DataConfigurationInterface
{
    public const CONFIG_KEY = 'MY_MODULE_CONFIGURATION_TEXT';
    public const MAX_LENGTH = 32;
    public const CONFIG_MENU = 'MYMODULE_SHOW_IN_MENU';
    public const CONFIG_LANGUAGE = 'MYMODULE_LANGUAGE';



    /**
     * @var ConfigurationInterface
     */
    private $configuration;

    public function __construct(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getConfiguration(): array
    {

        return [
            'config_text' => $this->configuration->get(static::CONFIG_KEY),
            'show_in_menu' => (bool) $this->configuration->get(static::CONFIG_MENU),
            'language' => $this->configuration->get(static::CONFIG_LANGUAGE),
        ];
    }

    public function updateConfiguration(array $configuration): array
    {
        $errors = [];

        if ($this->validateConfiguration($configuration)) {
            if (strlen($configuration['config_text']) <= static::MAX_LENGTH) {
                $this->configuration->set(static::CONFIG_KEY, $configuration['config_text']);
            } else {
                $errors[] = 'CONFIG_KEY value is too long';
            }
            $this->configuration->set(static::CONFIG_MENU, (bool) $configuration['show_in_menu']);
            $this->configuration->set(static::CONFIG_LANGUAGE, $configuration['language']);

        }

        return $errors;
    }

    /**
     * Ensure the parameters passed are valid.
     *
     * @return bool Returns true if no exception are thrown
     */
    public function validateConfiguration(array $configuration): bool
    {
        return isset($configuration['config_text']);
    }
}
