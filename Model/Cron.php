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

namespace Twilio\Notification\Model;

use Twilio\Notification\Api\Data\CronInterfaceFactory;
use Twilio\Notification\Api\Data\CronInterface;
use Magento\Framework\Api\DataObjectHelper;
use \Twilio\Notification\Model\ResourceModel\Cron as CronResource ;
use \Twilio\Notification\Model\ResourceModel\Cron\Collection;
class Cron extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{

    protected $dataObjectHelper;

    protected $cronDataFactory;

    const CACHE_TAG = 'twilio_notification_cron';
    protected $_cacheTag = 'twilio_notification_cron';
    protected $_eventPrefix = 'twilio_notification_cron';

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param CronInterfaceFactory $cronDataFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param CronResource $resource
     * @param \Twilio\Notification\Model\ResourceModel\Cron\Collection $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        CronInterfaceFactory $cronDataFactory,
        DataObjectHelper $dataObjectHelper,
        CronResource $resource,
        Collection $resourceCollection,
        array $data = []
    ) {
        $this->cronDataFactory = $cronDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * Retrieve cron model with cron data
     * @return CronInterface
     */
    public function getDataModel()
    {
        $cronData = $this->getData();
        
        $cronDataObject = $this->cronDataFactory->create();
        $this->dataObjectHelper->populateWithArray(
            $cronDataObject,
            $cronData,
            CronInterface::class
        );
        
        return $cronDataObject;
    }

    /**
     * @return array|string[]
     */
    public function getIdentities(){
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return array
     */
    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }
}
