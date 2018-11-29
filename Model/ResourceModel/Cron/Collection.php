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

namespace Twilio\Notification\Model\ResourceModel\Cron;

use \Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Twilio\Notification\Cron\Twilio;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /** @var  \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone */
    protected $timezone;


    /**
     * Collection constructor.
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param TimezoneInterface $timezone
     * @param \Magento\Framework\DB\Adapter\AdapterInterface|null $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb|null $resource
     */
    public function __construct(\Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
                                \Psr\Log\LoggerInterface $logger,
                                \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
                                \Magento\Framework\Event\ManagerInterface $eventManager,
                                TimezoneInterface $timezone,
                                \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
                                \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    )
    {
        $this->timezone = $timezone;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

/**
     * Define resource model
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Twilio\Notification\Model\Cron::class,
            \Twilio\Notification\Model\ResourceModel\Cron::class
        );
    }


    /**
     * @return Collection
     */
    public function loadNewCrons()
    {
        $now  = $this->timezone->date(new \DateTime("now"));
        $before_5_min = $this->timezone->date(new \DateTime("-5 min"));
        return $this->addFieldToSelect("*")
                    ->addFieldToFilter("status" ,["eq" => \Twilio\Notification\Helper\Data::STATUS_NEW])
                    //->addFieldToFilter('created_at', ['lteq' => $now->format('Y-m-d H:i:s')])
                    //->addFieldToFilter('created_at', ['gteq' => $before_5_min->format('Y-m-d H:i:s')])
                    ->setOrder("created_at" , "ASC")
                    ->load();
    }
}
