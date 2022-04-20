<?php

declare(strict_types=1);

namespace App\Security;

/**
 * Class OAuthUser.
 */
final class OAuthUser
{
    /**
     * Unique id/username from the resource.
     *
     * @var string
     */
    private $id;

    /**
     * Name of the resource (facebook, google..).
     *
     * @var string
     */
    private $resourceOwner;

    /**
     * first name.
     *
     * @var string|null
     */
    private $firstName;

    /**
     * last name.
     *
     * @var string|null
     */
    private $lastName;

    /**
     * email.
     *
     * @var string
     */
    private $email;

    /**
     * url to profile picture.
     *
     * @var string|null
     */
    private $profilePicture;

    /**
     * gender.
     *
     * null = unknown
     * 1    = male
     * 0    = female
     *
     * @var int|null
     */
    private $gender;

    /**
     * Date of birth.
     *
     * @var \DateTime|null
     */
    private $dateOfBirth;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getResourceOwner(): string
    {
        return $this->resourceOwner;
    }

    /**
     * @param string $resourceOwner
     */
    public function setResourceOwner(string $resourceOwner): void
    {
        $this->resourceOwner = $resourceOwner;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return mb_strtolower($this->email);
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    /**
     * @param string|null $profilePicture
     */
    public function setProfilePicture(?string $profilePicture): void
    {
        $this->profilePicture = $profilePicture;
    }

    /**
     * @return int|null
     */
    public function getGender(): ?int
    {
        return $this->gender;
    }

    /**
     * @param int|null $gender
     */
    public function setGender(?int $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateOfBirth(): ?\DateTime
    {
        return $this->dateOfBirth;
    }

    /**
     * @param \DateTime|null $dateOfBirth
     */
    public function setDateOfBirth(?\DateTime $dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }
}
