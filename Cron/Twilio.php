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

namespace Twilio\Notification\Cron;
use Twilio\Notification\Helper\Data;
use \Psr\Log\LoggerInterface;
use \Twilio\Notification\Model\CronFactory;
class Twilio
{

    /**
     * @var LoggerInterface
     */
    protected $logger;


    /**
     * @var Data
     */
    protected $helper;

    /**
     * @var \Twilio\Notification\Model\CronFactory
     */
    protected $cronFactory;

    /**
     * Constructor
     * @param LoggerInterface $logger
     * @param Data $helper
     * @param CronFactory $cronFactory
     */
    public function __construct(LoggerInterface $logger , Data $helper , CronFactory $cronFactory )
    {
        $this->logger = $logger;
        $this->cronFactory = $cronFactory;
        $this->helper = $helper;
    }

    /**
     * Execute the cron
     * @return bool
     * @throws \Exception
     */
    public function execute()
    {
        $this->logger->addInfo("Cronjob Twilio is executed.");
        $crons = $this->cronFactory->create()->getCollection()->loadNewCrons();
        if($crons->count() <= 0 ){
            return false;
        }
        /** @var \Twilio\Notification\Model\Cron $c */
        foreach ($crons as $cron){
            try {
                $response = $this->helper->callTwiML($cron->getData("markup"), $cron->getData("number"));
                $cron->setStatus( Data::STATUS_FINISHED);
                $cron->setProcessedAt($this->helper->getTimeNow()->format("Y-m-d H:i:s"));
                $cron->setResponse($response);
            }catch (\Twilio\Exceptions\TwilioException $e){
                $cron->setStatus("status", Data::STATUS_FAILED);
                $cron->setProcessedAt( $this->helper->getTimeNow()->format("Y-m-d H:i:s"));
                $cron->setResponse( $e->getMessage());
                $this->logger->critical($e);
            }catch (\Exception $e){
                $cron->setStatus("status", Data::STATUS_FAILED);
                $cron->setProcessedAt( $this->helper->getTimeNow()->format("Y-m-d H:i:s"));
                $cron->setResponse( $e->getMessage());
                $this->logger->critical($e);
            }
            $cron->save();
        }
        return true;
    }
}
