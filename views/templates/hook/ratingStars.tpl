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
<span class="float-right rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
  {if $rating}
    <span itemprop="ratingValue">{$rating.average|string_format:"%.1f"}</span> <i class="material-icons">star</i>
    <meta itemprop="ratingCount" content="{$rating.count}"/>
  {/if}
</span>
<!-- /Block mymodule -->