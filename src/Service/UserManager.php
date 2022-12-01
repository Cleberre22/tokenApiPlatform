<?php

namespace App\Service;

use App\Entity\Users;

class UserManager
{
    private $user = null;

    public function setCurrentUser(?Users $user)
    {
        if ($user && $this->user && ($this->user->getTokens() != $user->getTokens())) 
        {
            throw new \Exception("Current user can't be change during same request", 1);   
        }

        $this->user = $user;
    }

    public function getCurrentUser()
    {
        return $this->user;
    }

    public function getCurrentUserId()
    {
        return $this->user->getId();
    }
}