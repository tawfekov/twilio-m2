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

namespace Twilio\Notification\Model\Data;

use Twilio\Notification\Api\Data\CronInterface;

class Cron extends \Magento\Framework\Api\AbstractExtensibleObject implements CronInterface
{

    /**
     * Get cron_id
     * @return string|null
     */
    public function getCronId()
    {
        return $this->_get(self::CRON_ID);
    }

    /**
     * Set cron_id
     * @param string $cronId
     * @return \Twilio\Notification\Api\Data\CronInterface
     */
    public function setCronId($cronId)
    {
        return $this->setData(self::CRON_ID, $cronId);
    }

    /**
     * Get target_id
     * @return string|null
     */
    public function getTargetId()
    {
        return $this->_get(self::TARGET_ID);
    }

    /**
     * Set target_id
     * @param string $targetId
     * @return \Twilio\Notification\Api\Data\CronInterface
     */
    public function setTargetId($targetId)
    {
        return $this->setData(self::TARGET_ID, $targetId);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     * @return \Twilio\Notification\Api\Data\CronExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Set an extension attributes object.
     * @param \Twilio\Notification\Api\Data\CronExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Twilio\Notification\Api\Data\CronExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Get markup
     * @return string|null
     */
    public function getMarkup()
    {
        return $this->_get(self::MARKUP);
    }

    /**
     * Set markup
     * @param string $markup
     * @return \Twilio\Notification\Api\Data\CronInterface
     */
    public function setMarkup($markup)
    {
        return $this->setData(self::MARKUP, $markup);
    }

    /**
     * Get response
     * @return string|null
     */
    public function getResponse()
    {
        return $this->_get(self::RESPONSE);
    }

    /**
     * Set response
     * @param string $response
     * @return \Twilio\Notification\Api\Data\CronInterface
     */
    public function setResponse($response)
    {
        return $this->setData(self::RESPONSE, $response);
    }

    /**
     * Get status
     * @return string|null
     */
    public function getStatus()
    {
        return $this->_get(self::STATUS);
    }

    /**
     * Set status
     * @param string $status
     * @return \Twilio\Notification\Api\Data\CronInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Get created_at
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->_get(self::CREATED_AT);
    }

    /**
     * Set created_at
     * @param string $createdAt
     * @return \Twilio\Notification\Api\Data\CronInterface
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get processed_at
     * @return string|null
     */
    public function getProcessedAt()
    {
        return $this->_get(self::PROCESSED_AT);
    }

    /**
     * Set processed_at
     * @param string $processedAt
     * @return \Twilio\Notification\Api\Data\CronInterface
     */
    public function setProcessedAt($processedAt)
    {
        return $this->setData(self::PROCESSED_AT, $processedAt);
    }

    /**
     * Get number
     * @return string|null
     */
    public function getNumber()
    {
        return $this->_get(self::NUMBER);
    }

    /**
     * Set number
     * @param string $number
     * @return \Twilio\Notification\Api\Data\CronInterface
     */
    public function setNumber($number)
    {
        return $this->setData(self::NUMBER, $number);
    }

    /**
     * Get type
     * @return string|null
     */
    public function getType()
    {
        return $this->_get(self::TYPE);
    }

    /**
     * Set type
     * @param string $type
     * @return \Twilio\Notification\Api\Data\CronInterface
     */
    public function setType($type)
    {
        return $this->setData(self::TYPE, $type);
    }
}
