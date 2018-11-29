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
namespace Twilio\Notification\Model\Options;

use Twilio\Notification\Helper\Data;

class Status implements \Magento\Framework\Option\ArrayInterface
{
    public function toOptionArray()
    {
        $options = [];
        $options[] = ['label' => Data::STATUS_NEW, 'value' => Data::STATUS_NEW];
        $options[] = ['label' => Data::STATUS_PROCESSING, 'value' => Data::STATUS_PROCESSING];
        $options[] = ['label' => Data::STATUS_FAILED, 'value' => Data::STATUS_FAILED];
        $options[] = ['label' => Data::STATUS_FINISHED, 'value' => Data::STATUS_FINISHED];
        return $options;
    }
}