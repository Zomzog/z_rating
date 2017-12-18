<?php
/**
 * Cookies alert
 * Copyright (C) 2017  Zomzog
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 * @author Zomzog <zomzog@zomzog.fr>
 * @copyright  2017-2017 Zomzog
 * @license    http://www.gnu.org/licenses/  GNU GENERAL PUBLIC LICENSE (GPL-3.0)
 *
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class Z_Rating extends Module
{
    public function __construct()
    {
        $this->name = 'z_rating';
        $this->tab = 'front_office_features';
        $this->version = '0.1.0';
        $this->author = 'Zomzog';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Product rating');
        $this->description = $this->l('Product rating.');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall? :(');

        if (!Configuration::get('Z_PRODUCT_RATING_NAME'))
            $this->warning = $this->l('No name provided');
    }

    public function uninstall()
    {
        Db::getInstance()->execute('DROP TABLE IF EXISTS '._DB_PREFIX_.'z_rating');
        return parent::uninstall();
    }

    public function install()
    {
        Logger::addLog('Start install', 2);
        if (Shop::isFeatureActive())
            Shop::setContext(Shop::CONTEXT_ALL);

        $installed  = parent::install() &&
            $this->registerHook('displayProductListReviews') &&
            $this->registerHook('header');

        if ($installed) {
            Logger::addLog('2: installed ok', 2);
            $this->createTable();
            return true;
        }
        Logger::addLog('You failed !', 2);
        return false;
    }

    private static function createTable()
    {
        Db::getInstance()->execute('
		CREATE TABLE `'._DB_PREFIX_.'z_rating` (
		    `id_rating` int(10) unsigned NOT NULL AUTO_INCREMENT,
			`id_product` int(10) unsigned NOT NULL,
			`id_shop` int(11) NOT NULL,
			`id_customer` int(10) unsigned NOT NULL,
			`id_order` int(10) unsigned NOT NULL,
			`rate` INT NOT NULL,
			`comment` VARCHAR(128),
		PRIMARY KEY (`id_rating`),
		INDEX `id_product` (`id_product`),
		CONSTRAINT `z_rating_product` FOREIGN KEY (`id_product`) REFERENCES `'._DB_PREFIX_.'product` (`id_product`) ON DELETE NO ACTION ON UPDATE NO ACTION,
		CONSTRAINT `z_rating_shop` FOREIGN KEY (`id_shop`) REFERENCES `'._DB_PREFIX_.'shop` (`id_shop`) ON DELETE NO ACTION ON UPDATE NO ACTION,
		CONSTRAINT `z_rating_customer` FOREIGN KEY (`id_customer`) REFERENCES `'._DB_PREFIX_.'customer` (`id_customer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
		CONSTRAINT `z_rating_order` FOREIGN KEY (`id_order`) REFERENCES `'._DB_PREFIX_.'orders` (`id_order`) ON DELETE NO ACTION ON UPDATE NO ACTION);
		)  ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;');
        Logger::addLog('Create table OK', 1);
    }

    /**
     * Hook to product list reviews
     * @param $params
     * @return mixed
     */
    public function hookDisplayProductListReviews($params)
    {
        $productId = $params['product']['id_product'];
        $rate = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
            'SELECT SUM(`rate`) as r, COUNT(*) as c 
			FROM '._DB_PREFIX_.'z_rating
			WHERE `id_product` = '.(int) $productId
        );
        $r = $rate[0]['r'];
        $c = $rate[0]['c'];
        if($c > 0) {
            $average = $r/$c;
            $this->context->smarty->assign('rating', ['average' => $average, 'count' => $c]);
        } else {
            $this->context->smarty->assign('rating', null);
        }
        return $this->display(__FILE__, 'z_rating.tpl');
    }

    /**
     * Add CSS to header
     */
    public function hookDisplayHeader()
    {
        $this->context->controller->registerStylesheet('modules-z_productrating', 'modules/' . $this->name . '/views/css/z_rating.css', ['media' => 'all', 'priority' => 150]);
        $this->context->controller->registerJavascript('modules-z_productrating', 'modules/' . $this->name . '/views/js/z_rating.js', ['position' => 'bottom', 'priority' => 150]);
    }

    /**
     * Enable configuration
     * @return string
     */
    public function getContent()
    {
        $output = null;

        if (Tools::isSubmit('submit' . $this->name)) {
            $z_rating_name = (String)Tools::getValue('Z_PRODUCT_RATING_NAME');
            if (!$z_rating_name
                || empty($z_rating_name)
                || !Validate::isGenericName($z_rating_name))
                $output .= $this->displayError($this->l('Invalid Configuration value'));
            else {
                Configuration::updateValue('Z_PRODUCT_RATING_NAME', $z_rating_name);
                $output .= $this->displayConfirmation($this->l('Settings updated'));
            }
        }
        return $output . $this->displayConfigForm();
    }

    /**
     * Display configuration form
     * @return mixed
     */
    public function displayConfigForm()
    {
        // Get default language
        $default_lang = (int)Configuration::get('PS_LANG_DEFAULT');

        // Init Fields form array
        $fields_form = array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Message'),
                        'name' => 'Z_PRODUCT_RATING_MESSAGE',
                        'size' => 128,
                        'required' => true
                    )
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                    'class' => 'btn btn-default pull-right'
                )
            )
        );

        $helper = new HelperForm();

        // Module, token and currentIndex
        $helper->module = $this;
        $helper->name_controller = $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');
        $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;

        // Language
        $helper->default_form_language = $default_lang;
        $helper->allow_employee_form_lang = $default_lang;

        // Title and toolbar
        $helper->title = $this->displayName;
        $helper->show_toolbar = true;        // false -> remove toolbar
        $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
        $helper->submit_action = 'submit' . $this->name;
        $helper->toolbar_btn = array(
            'save' =>
                array(
                    'desc' => $this->l('Save'),
                    'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&save' . $this->name .
                        '&token=' . Tools::getAdminTokenLite('AdminModules'),
                ),
            'back' => array(
                'href' => AdminController::$currentIndex . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                'desc' => $this->l('Back to list')
            )
        );

        // Load current value
        $helper->fields_value['Z_PRODUCT_RATING_MESSAGE'] = Configuration::get('Z_PRODUCT_RATING_MESSAGE');

        return $helper->generateForm(array($fields_form));
    }
}