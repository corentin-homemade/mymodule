<?php

class MyModule extends Module
{

    public function __construct()
    {
        $this->name = 'mymodule';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Corentin Lartigue';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.7.0.0',
            'max' => '8.99.99',
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('My module', [], 'Modules.Mymodule.Admin');
        $this->description = $this->trans('Description of my module.', [], 'Modules.Mymodule.Admin');

        $this->confirmUninstall = $this->trans('Are you sure you want to uninstall?', [], 'Modules.Mymodule.Admin');

        if (!Configuration::get('MYMODULE_NAME')) {
            $this->warning = $this->trans('No name provided', [], 'Modules.Mymodule.Admin');
        }
    }

    public function getContent()
    {
        $route = $this->get('router')->generate('my_module_configuration');
        Tools::redirectAdmin($route);
    }



    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }

        return (
            parent::install()
            && Configuration::updateValue('MYMODULE_NAME', 'my module')
            && Configuration::updateValue('MYMODULE_SHOW_IN_MENU', false)
            && Configuration::updateValue('MY_MODULE_CONFIGURATION_TEXT', '')
            && Configuration::updateValue('MYMODULE_LANGUAGE', 'en')
        );
    }

    public function uninstall()
    {
        return (
            parent::uninstall()
            && Configuration::deleteByName('MYMODULE_NAME')
            && Configuration::deleteByName('MYMODULE_SHOW_IN_MENU')
            && Configuration::deleteByName('MY_MODULE_CONFIGURATION_TEXT')
            && Configuration::deleteByName('MYMODULE_LANGUAGE')

        );
    }


    private function installTab()
    {
        $tab = new Tab();
        $tab->class_name = 'MyModuleController';
        $tab->id_parent = (int) Tab::getIdFromClassName('IMPROVE');
        $tab->module = $this->name;
        $tab->route_name = 'my_module_index';
        $tab->active = true;
        $languages = Language::getLanguages();
        $tab->name = [];
        foreach ($languages as $lang) {
            $tab->name[$lang['id_lang']] = $this->trans('My module', [], 'Modules.Mymodule.Admin');
        }
        return $tab->add();
    }

    private function uninstallTab()
    {
        $id_tab = (int) Tab::getIdFromClassName('MyModuleController');
        if ($id_tab) {
            $tab = new Tab($id_tab);
            return $tab->delete();
        }
        return true;
    }


    public function updateTabVisibility()
    {
        if (Configuration::get('MYMODULE_SHOW_IN_MENU')) {
            if (!Tab::getIdFromClassName('MyModuleController')) {
                return $this->installTab();
            }
        } else {
            $this->uninstallTab();
        }
    }




}
