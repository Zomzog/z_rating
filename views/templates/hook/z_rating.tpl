{*
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
*}
<!-- Block mymodule -->
<div id="cookies_alert" class="cookies_alert" data-url="{url entity='module' name='z_cookiesalert' controller='Cookies' params = [action => 'action_name']}">
    <div class="cookie-close accept-cookie"><i class="material-icons">close</i></div>
    <div class="container">
        <p>
            {if isset($z_cookies_alert_message) && $z_cookies_alert_message}
                {$z_cookies_alert_message}
            {else}
                z_cookies_alert_message must be configured !
            {/if}
        </p>
    </div>
</div>
<!-- /Block mymodule -->