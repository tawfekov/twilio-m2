<?php
/**
 * A Magento 2 module named Twilio/Notification
 * Copyright (C) 2017 Tawfek Daghistani
 * 
 * This file is part of Twilio/Notification.
 * 
 * Twilio/Notification is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Twilio\Notification\Api\Data;

interface CronSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get Cron list.
     * @return \Twilio\Notification\Api\Data\CronInterface[]
     */
    public function getItems();

    /**
     * Set target_id list.
     * @param \Twilio\Notification\Api\Data\CronInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}