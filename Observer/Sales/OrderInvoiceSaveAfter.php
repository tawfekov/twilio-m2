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

namespace Twilio\Notification\Observer\Sales;

use Magento\Setup\Module\Di\Compiler\Log\Log;
use Psr\Log\LoggerInterface;
use \Magento\Framework\Event\Observer;
use Twilio\Notification\Helper\Data;

class OrderInvoiceSaveAfter implements \Magento\Framework\Event\ObserverInterface
{
    /** @var LoggerInterface  */
    protected $logger;


    /** @var Data */
    protected $helper;

    const type = "Invoice";

    /**
     * OrderInvoiceRegister constructor.
     * @param LoggerInterface $logger
     * @param Data $helper
     */
    public function __construct(LoggerInterface $logger , Data $helper )
    {
        $this->logger = $logger;
        $this->helper = $helper;
    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try{
            $this->helper->AddNewCronTask($observer , self::type);
        }catch (\Exception $exception){
            $this->logger->critical($exception);
        }
    }
}
