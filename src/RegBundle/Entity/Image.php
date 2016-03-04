<?php

// src/RegBundle/Entity/Image.php
namespace RegBundle\Entity;


class Image 
{
    protected $id;
    protected $image;
    protected $u_image;
    protected $s_image;
    protected $l_image;
    protected $p_image;


    /**
     * @var string
     */
    private $user_image;

    /**
     * @var string
     */
    private $like_image;

    /**
     * @var string
     */
    private $share_image;

    /**
     * @var boolean
     */
    private $profile_image;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Image
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set userImage
     *
     * @param string $userImage
     *
     * @return Image
     */
    public function setUserImage($userImage)
    {
        $this->user_image = $userImage;

        return $this;
    }

    /**
     * Get userImage
     *
     * @return string
     */
    public function getUserImage()
    {
        return $this->user_image;
    }

    /**
     * Set likeImage
     *
     * @param string $likeImage
     *
     * @return Image
     */
    public function setLikeImage($likeImage)
    {
        $this->like_image = $likeImage;

        return $this;
    }

    /**
     * Get likeImage
     *
     * @return string
     */
    public function getLikeImage()
    {
        return $this->like_image;
    }

    /**
     * Set shareImage
     *
     * @param string $shareImage
     *
     * @return Image
     */
    public function setShareImage($shareImage)
    {
        $this->share_image = $shareImage;

        return $this;
    }

    /**
     * Get shareImage
     *
     * @return string
     */
    public function getShareImage()
    {
        return $this->share_image;
    }

    /**
     * Set profileImage
     *
     * @param boolean $profileImage
     *
     * @return Image
     */
    public function setProfileImage($profileImage)
    {
        $this->profile_image = $profileImage;

        return $this;
    }

    /**
     * Get profileImage
     *
     * @return boolean
     */
    public function getProfileImage()
    {
        return $this->profile_image;
    }
}
