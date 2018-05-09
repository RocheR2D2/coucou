<?php

namespace AppBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Uid
 *
 * @ORM\Table(name="uid")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UidRepository")
 */
class Uid implements UserInterface, \Serializable
{

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="uid", type="string", length=255, nullable=false)
     */
    private $uid;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return number
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param string $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function serialize()
    {

        return serialize([
            $this->id,
            $this->username,
            $this->password,
        ]);

    }

    public function unserialize($serialized)
    {

        list(
            $this->id,
            $this->username,
            $this->password,
            ) = unserialize($serialized);

    }
    public function eraseCredentials()
    {}

    public function getSalt()
    {}

    public function getRoles()
    {
        return [
            'ROLE_USER',
        ];
    }





    


}

