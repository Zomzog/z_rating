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
    <div>
        <span class="rating material-align" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
            <span itemprop="ratingValue">{$rating.average}</span> <i class="material-icons">star</i>

            {for $i=1 to 5}
                {if $i<=$rating.average}
                    <i class="material-icons">star</i>
                {elseif $i<$rating.average+1}
                    <i class="material-icons">star_half</i>
                {else}
                    <i class="material-icons">star_border</i>
                {/if}
            {/for}
            <span itemprop="ratingCount" content="{$rating.count}">({$rating.count})</span>
        </span>
        <table class="ratingResume">
            {for $r=5 to 1 step -1}
                {assign var="percent" value="{$ratingCounters[$r]/{$rating.count}*100}"}
                <tr>
                    <td class="stars">{$r} étoiles</td>
                    <td class="progressBar">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {$percent}%" aria-valuenow="{$ratingCounters[$r]}" aria-valuemin="0" aria-valuemax="{$rating.count}"></div>
                        </div>
                    </td>
                    <td class="percent">{$percent|string_format:"%d"}%</td>
                </tr>
            {/for}
        </table>
    </div>
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