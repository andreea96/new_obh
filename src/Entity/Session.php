<?php


namespace App\Entity;


class Session
{
    private $clientId;
    private $skill;
    private $clientAppKey;

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     * @return Session
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * @param mixed $skill
     * @return Session
     */
    public function setSkill($skill)
    {
        $this->skill = $skill;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClientAppKey()
    {
        return $this->clientAppKey;
    }

    /**
     * @param mixed $clientAppKey
     * @return Session
     */
    public function setClientAppKey($clientAppKey)
    {
        $this->clientAppKey = $clientAppKey;
        return $this;
    }
}