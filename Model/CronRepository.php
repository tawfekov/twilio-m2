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

use Twilio\Notification\Api\Data\CronSearchResultsInterfaceFactory;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Twilio\Notification\Api\CronRepositoryInterface;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Exception\CouldNotDeleteException;
use Twilio\Notification\Api\Data\CronInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;
use Twilio\Notification\Model\ResourceModel\Cron as ResourceCron;
use Magento\Framework\Api\ExtensionAttribute\JoinProcessorInterface;
use Twilio\Notification\Model\ResourceModel\Cron\CollectionFactory as CronCollectionFactory;

class CronRepository implements CronRepositoryInterface
{

    protected $dataObjectProcessor;

    protected $dataCronFactory;

    protected $dataObjectHelper;

    private $storeManager;

    protected $resource;

    protected $searchResultsFactory;

    private $collectionProcessor;

    protected $extensibleDataObjectConverter;
    protected $cronCollectionFactory;

    protected $extensionAttributesJoinProcessor;

    protected $cronFactory;


    /**
     * @param ResourceCron $resource
     * @param CronFactory $cronFactory
     * @param CronInterfaceFactory $dataCronFactory
     * @param CronCollectionFactory $cronCollectionFactory
     * @param CronSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     * @param CollectionProcessorInterface $collectionProcessor
     * @param JoinProcessorInterface $extensionAttributesJoinProcessor
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        ResourceCron $resource,
        CronFactory $cronFactory,
        CronInterfaceFactory $dataCronFactory,
        CronCollectionFactory $cronCollectionFactory,
        CronSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager,
        CollectionProcessorInterface $collectionProcessor,
        JoinProcessorInterface $extensionAttributesJoinProcessor,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->resource = $resource;
        $this->cronFactory = $cronFactory;
        $this->cronCollectionFactory = $cronCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataCronFactory = $dataCronFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
        $this->collectionProcessor = $collectionProcessor;
        $this->extensionAttributesJoinProcessor = $extensionAttributesJoinProcessor;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Twilio\Notification\Api\Data\CronInterface $cron
    ) {
        /* if (empty($cron->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $cron->setStoreId($storeId);
        } */
        
        $cronData = $this->extensibleDataObjectConverter->toNestedArray(
            $cron,
            [],
            \Twilio\Notification\Api\Data\CronInterface::class
        );
        
        $cronModel = $this->cronFactory->create()->setData($cronData);
        
        try {
            $this->resource->save($cronModel);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the cron: %1',
                $exception->getMessage()
            ));
        }
        return $cronModel->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getById($cronId)
    {
        $cron = $this->cronFactory->create();
        $this->resource->load($cron, $cronId);
        if (!$cron->getId()) {
            throw new NoSuchEntityException(__('Cron with id "%1" does not exist.', $cronId));
        }
        return $cron->getDataModel();
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->cronCollectionFactory->create();
        
        $this->extensionAttributesJoinProcessor->process(
            $collection,
            \Twilio\Notification\Api\Data\CronInterface::class
        );
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model->getDataModel();
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Twilio\Notification\Api\Data\CronInterface $cron
    ) {
        try {
            $this->resource->delete($cron);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Cron: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($cronId)
    {
        return $this->delete($this->getById($cronId));
    }
}
