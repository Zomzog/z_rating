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

require_once _PS_MODULE_DIR_.'z_cookiesalert/z_cookiesalert.php';

class Z_CookiesalertCookiesModuleFrontController extends ModuleFrontController {

    public function initContent()
    {
        $module = new Z_Cookiesalert;

        // You may should do some security work here, like checking an hash from your module
        if (Tools::isSubmit('action')) {

            // Usefull vars derivated from getContext
            $context = Context::getContext();
            $cookie = $context->cookie;

            $cookie->__set('zcookiealert', "accepted");

            // Default response with translation from the module
            $response = array('status' => true, "message" => $module->l('Done.'));
        }

        // Classic json response
        die(Tools::jsonEncode($response));
    }
    // displayAjax for FrontEnd Invoke the ajax action
    // ajaxProcess for BackEnd Invoke the ajax action

    public function displayAjaxAcceptCookies()
    {

        header('Content-Type: application/json');
        die(Tools::jsonEncode(array('cookie'=> "accepted")));
    }
}