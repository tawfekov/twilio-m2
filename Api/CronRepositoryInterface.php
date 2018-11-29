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

namespace Twilio\Notification\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface CronRepositoryInterface
{

    /**
     * Save Cron
     * @param \Twilio\Notification\Api\Data\CronInterface $cron
     * @return \Twilio\Notification\Api\Data\CronInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Twilio\Notification\Api\Data\CronInterface $cron
    );

    /**
     * Retrieve Cron
     * @param string $cronId
     * @return \Twilio\Notification\Api\Data\CronInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($cronId);

    /**
     * Retrieve Cron matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Twilio\Notification\Api\Data\CronSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Cron
     * @param \Twilio\Notification\Api\Data\CronInterface $cron
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Twilio\Notification\Api\Data\CronInterface $cron
    );

    /**
     * Delete Cron by ID
     * @param string $cronId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($cronId);
}
