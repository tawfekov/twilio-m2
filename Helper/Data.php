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

namespace Twilio\Notification\Helper;

use Magento\Catalog\Test\Block\Adminhtml\Product\Edit\Section\Options\Type\Time;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Setup\Exception;
use Twilio\Rest\Client ;
use Twilio\Notification\Cron\Twilio;
use \Magento\Framework\Event\Observer;
use \Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Twilio\Notification\Model\Cron;
use Twilio\Notification\Model\CronFactory;

class Data extends AbstractHelper
{

    /// cron statues
    const STATUS_NEW = "New";
    const STATUS_PROCESSING = "Processing";
    const STATUS_FINISHED = "Finished";
    const STATUS_FAILED = "Failed";


    /// cron types
    const TYPE_ORDER = "Order";
    const TYPE_INVOICE = "Invoice";
    const TYPE_SHIPMENT = "Shipment";

    const ECHO_SERVICE_URL = "http://twimlets.com/echo";


    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    protected $scopeConfig;

    /** @var  \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone */
    protected $timezone;

    /** @var \Twilio\Notification\Model\CronFactory */
    protected $cronFactory;


    /**
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param TimezoneInterface $timezone
     * @param CronFactory $cronFactory
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        TimezoneInterface $timezone ,
        CronFactory $cronFactory,
        \Magento\Framework\App\Helper\Context $context
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->timezone = $timezone;
        $this->cronFactory = $cronFactory;
        parent::__construct($context);
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return true;
    }

    /**
     * @return Client
     * @throws \Twilio\Exceptions\ConfigurationException
     */
    public function getTwilioClient()
    {
        $sid = $this->getConfig('twilio/api/sid');
        $token = $this->getConfig('twilio/api/token');
        return new Client($sid,$token);
    }


    /**
     * @return bool
     */
    public function checkIfShipmentNotificationEnabled()
    {
        return (bool) $this->getConfig("twilio/notifications/run_twiml_new_shipment");
    }

    /**
     * @return bool
     */
    public function checkIfInvoicerNotificationEnabled()
    {
        return (bool) $this->getConfig("twilio/notifications/run_twiml_new_invoice");
    }

    /**
     * @return bool
     */
    public function checkIfOrderNotificationEnabled()
    {
        return (bool) $this->getConfig("twilio/notifications/run_twiml_new_order");
    }

    /**
     * compile template
     * @param target object $target
     * @param string $type it can be order/invoice/shipment
     * @return mixed
     */
    public function getTwiMLFor($target , $type = "order")
    {
        $type = strtolower($type);
        $template = $this->getConfig("twilio/notifications/{$type}_twiml");
        $matches = [] ;
        preg_match_all("/\{\{[A-Za-z0-9_]*\}\}/" , $template , $matches );
        if(count($matches[0]) > 0 ){
            foreach($matches[0] as $key => $match){
                $match_name = str_replace(["{" , "}"] , "" , trim($match));
                $template = str_replace($match , $target->getData($match_name) , $template);
            }
        }
        return $template;
    }

    /**
     * @param $TwiML
     * @param $to
     * @return \Twilio\Rest\Api\V2010\Account\CallInstance
     * @throws \Twilio\Exceptions\ConfigurationException
     * @throws \Twilio\Exceptions\TwilioException
     */
    public function callTwiML($TwiML , $to)
    {
        /** @var Client $client */
        $client = $this->getTwilioClient();
        $from = $this->getConfig("twilio/notifications/from");
        $record = $this->getConfig("twilio/api/record");
        $TwiMLurl = self::ECHO_SERVICE_URL . "?Twiml=" . urlencode($TwiML);
        try{
            $this->_logger->info($TwiMLurl);
            $call =  $client->calls->create($to , $from  , ["url" => $TwiMLurl , "Record" => $record] );
            return $call->sid;
        }catch (TwilioException $e){
            $this->_logger->critical($e);
            return $e->getMessage();
        }catch (\Exception $e){
            $this->_logger->critical($e);
            return $e->getMessage();
        }
    }


    /**
     * @param Observer $observer
     * @param string $type
     * @return \Exception|Cron|bool
     */
    public function AddNewCronTask( Observer $observer , $type = "Order")
    {
        try{
            switch ($type){
                case self::TYPE_ORDER:
                    if(!$this->checkIfOrderNotificationEnabled()){
                        return false;
                    }
                    /** @var \Magento\Sales\Model\Order $target */
                    $target = $observer->getEvent()->getOrder();
                    $target_id = $target->getIncrementId();
                    $number = $target->getBillingAddress()->getTelephone();
                    break;
                case self::TYPE_INVOICE:
                    if(!$this->checkIfInvoicerNotificationEnabled()){
                        return false;
                    }
                    /** @var \Magento\Sales\Api\Data\InvoiceInterface $target */
                    $target = $observer->getEvent()->getInvoice();
                    /** @var \Magento\Sales\Model\Order $order */
                    $order   = $target->getOrder();
                    $number = $order->getBillingAddress()->getTelephone();
                    $target_id = $target->getIncrementId();
                    break;
                case self::TYPE_SHIPMENT:
                    if(!$this->checkIfShipmentNotificationEnabled()){
                        return false;
                    }
                    // TODO : should declare its class
                    $target = $observer->getEvent()->getShipment();
                    /** @var \Magento\Sales\Model\Order $order */
                    $order  = $target->getOrder();
                    $number = $order->getShippingAddress()->getTelephone();
                    $target_id = $target->getIncrementId();
                    break;
                default:
                    return new \Exception("type isn't valid ");
            }

            $markup = $this->getTwiMLFor($target , $type);
            $cronTask = $this->cronFactory->create();
            $cronTask->setData("target_id" , $target_id);
            $cronTask->setData("markup" , $markup);
            $cronTask->setData("status" , self::STATUS_NEW);
            $cronTask->setData("created_at" , $this->getTimeNow()->format("Y-m-d H:i:s"));
            $cronTask->setData("processed_at" , $this->getTimeNow()->format("Y-m-d H:i:s"));
            $cronTask->setData("number" , $number);
            $cronTask->setData("type" , $type );
            $cronTask->save();
            return $cronTask;
        }catch (\Exception $exception)
        {
            $this->_logger->critical($exception);
            return $exception;
        }
    }

    /**
     * @param $path
     * @return mixed
     */
    private function getConfig($path)
    {
        return $this->scopeConfig->getValue($path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return \DateTime
     */
    public function getTimeNow()
    {
        return  $this->timezone->date(new \DateTime("now"));
    }

}
