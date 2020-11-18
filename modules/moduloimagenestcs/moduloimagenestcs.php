<?php
/**
* 2007-2020 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2020 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Moduloimagenestcs extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'moduloimagenestcs';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'diego';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Banner Imagenes');
        $this->description = $this->l('Banner para poner dos imagenes');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('MODULOIMAGENESTCS_LIVE_MODE', false);

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayHome');
    }

    public function uninstall()
    {
        Configuration::deleteByName('MODULOIMAGENESTCS_LIVE_MODE');

        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitModuloimagenestcsModule')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $output.$this->renderForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitModuloimagenestcsModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        $file = '../modules/' . $this->name.'/views/img/'. Configuration::get('MODULOIMAGENESTCS_IMAGEN1');
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    
                    array(
                        'col' => 9,
                        'type' => 'file',
                        'desc' => $this->l('Introduce segunda imagen.'),
                        'name' => 'MODULOIMAGENESTCS_IMAGEN2',
                        'label' => $this->l('Segunda imagen'),
                    ),
                    array(
                        'type' => 'file',
                        'label' => $this->l('Image'),
                        'name' => 'mycustomimg',
                        'thumb' => file_exists($file) ? $file : '',
                        'hint' => $this->l('Upload and image file to be displayed.'),
                    ),
                ),

                
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            /* 'MODULOIMAGENESTCS_IMAGEN1' => Configuration::get('MODULOIMAGENESTCS_IMAGEN1'),
            'MODULOIMAGENESTCS_IMAGEN2' => Configuration::get('MODULOIMAGENESTCS_IMAGEN2'), */
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }

        if (Tools::isSubmit('Save')) {
            $error = '';
            if ($_FILES) {
                $helper = new HelperImageUploader('mycustomimg');
                $files = $helper->process();

                if ($files) {
                    foreach ($files as $file) {
                        if (isset($file['save_path'])) {

                            if (!$error) {
                                if (!ImageManager::resize($file['save_path'], dirname(__FILE__) . '/views/img/' . $file['name'])) {
                                    $error = Tools::DisplayError('An error occurred during the image upload');
                                } else {
                                    $previous_file = Configuration::get('MODULOIMAGENESTCS_IMAGEN1');
                                    $file_path = dirname(__FILE__) . '/views/img/' . $previous_file;

                                    if (file_exists($file_path) && $file['name'] != $previous_file) {
                                        unlink($file_path);
                                    }

                                    Configuration::updateValue('MODULOIMAGENESTCS_IMAGEN1', $file['name']);
                                }
                            }
                            unlink($file['save_path']);
                        }
                    }
                }
            }
        }


    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    public function hookDisplayHome()
    {

        $file = Configuration::get('MODULOIMAGENESTCS_IMAGEN1');
        $this->context->smarty->assign('custom_img', file_exists( dirname(__FILE__) .'/views/img/' . $file ) ? $this->name . '/views/img/' . $file : '');
        return $this->display(__FILE__, 'imagenes.tpl');
    }
}
