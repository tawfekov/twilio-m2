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

interface CronInterface extends \Magento\Framework\Api\ExtensibleDataInterface
{

    const RESPONSE = 'response';
    const NUMBER = 'number';
    const STATUS = 'status';
    const PROCESSED_AT = 'processed_at';
    const TARGET_ID = 'target_id';
    const TYPE = 'type';
    const CRON_ID = 'cron_id';
    const CREATED_AT = 'created_at';
    const MARKUP = 'markup';

    /**
     * Get cron_id
     * @return string|null
     */
    public function getCronId();

    /**
     * Set cron_id
     * @param string $cronId
     * @return \Twilio\Notification\Api\Data\CronInterface
     */
    public function setCronId($cronId);

    /**
     * Get target_id
     * @return string|null
     */
    public function getTargetId();

    /**
     * Set target_id
     * @param string $targetId
     * @return \Twilio\Notification\Api\Data\CronInterface
     */
    public function setTargetId($targetId);

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Twilio\Notification\Api\Data\CronExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     * @param \Twilio\Notification\Api\Data\CronExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Twilio\Notification\Api\Data\CronExtensionInterface $extensionAttributes
    );

    /**
     * Get markup
     * @return string|null
     */
    public function getMarkup();

    /**
     * Set markup
     * @param string $markup
     * @return \Twilio\Notification\Api\Data\CronInterface
     */
    public function setMarkup($markup);

    /**
     * Get response
     * @return string|null
     */
    public function getResponse();

    /**
     * Set response
     * @param string $response
     * @return \Twilio\Notification\Api\Data\CronInterface
     */
    public function setResponse($response);

    /**
     * Get status
     * @return string|null
     */
    public function getStatus();

    /**
     * Set status
     * @param string $status
     * @return \Twilio\Notification\Api\Data\CronInterface
     */
    public function setStatus($status);

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Twilio\Notification\Api\Data\CronInterface
     */
    public function setCreatedAt($createdAt);

    /**
     * Get processed_at
     * @return string|null
     */
    public function getProcessedAt();

    /**
     * Set processed_at
     * @param string $processedAt
     * @return \Twilio\Notification\Api\Data\CronInterface
     */
    public function setProcessedAt($processedAt);

    /**
     * Get number
     * @return string|null
     */
    public function getNumber();

    /**
     * Set number
     * @param string $number
     * @return \Twilio\Notification\Api\Data\CronInterface
     */
    public function setNumber($number);

    /**
     * Get type
     * @return string|null
     */
    public function getType();

    /**
     * Set type
     * @param string $type
     * @return \Twilio\Notification\Api\Data\CronInterface
     */
    public function setType($type);
}
