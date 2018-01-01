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
{if $rating}
<span class="rating material-align" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
    <span itemprop="ratingValue">{$rating.average|string_format:"%.1f"}</span> <i class="material-icons">star</i>
    <meta itemprop="ratingCount" content="{$rating.count}"/>
</span>
{/if}
{if $reviews}
    {foreach from=$reviews item=review}
        <div class="review" itemprop="review" itemscope itemtype="http://schema.org/Review">
            <span class="author" itemprop="author">{$review.customerName}</span> -
            <meta itemprop="datePublished" content="2011-04-01">April 1, 2011
            <div class="rating" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                <meta itemprop="worstRating" content = "1"/>
                <meta itemprop="ratingValue" content="{$review.rate}"/>
                <meta itemprop="bestRating" content="5"/>
                {for $i=1 to 5}
                    {if $i<=$review.rate}
                        <i class="material-icons">star</i>
                    {else}
                        <i class="material-icons">star_border</i>
                    {/if}
                {/for}
            </div>
            <div itemprop="description">{$review.comment}</div>
        </div>
    {/foreach}
{/if}
<!-- /Block mymodule -->