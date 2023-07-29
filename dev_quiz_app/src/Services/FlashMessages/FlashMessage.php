<?php

namespace App\Services\FlashMessages;

use App\Services\FlashMessages\FlashMessagesConstants;

class FlashMessage
{
    public function createFlashMessage(string $name, string $message, string $type): void
    {
        // remove existing message with the same name
        if (isset($_SESSION[FlashMessagesConstants::FLASH][$name])) {
            unset($_SESSION[FlashMessagesConstants::FLASH][$name]);
        }
        // add the message to the session
        $_SESSION[FlashMessagesConstants::FLASH][$name] = ['message' => $message, 'type' => $type];
    }
    
    public function getFlashMessages(): ?array
    {
        if (!isset($_SESSION[FlashMessagesConstants::FLASH])) {
            return null;
        }

        // get flash messages from session
        $flashMessages = $_SESSION[FlashMessagesConstants::FLASH];

        // remove flash messages from session
        unset($_SESSION[FlashMessagesConstants::FLASH]);

        $formattedMessages = [];
        
        // format flash messages
        foreach ($flashMessages as $flashMessage) {
            $formattedMessages[] = $this->formatFlashMessage($flashMessage);
        }

        return $formattedMessages;
    }

    private function formatFlashMessage(array $flashMessage): string
    {
        return sprintf(
            '<li class="flash flash-%s">%s</li>',
            $flashMessage['type'],
            $flashMessage['message']
        );
    }
}
