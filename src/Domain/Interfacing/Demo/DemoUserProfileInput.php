<?php

declare(strict_types=1);

/*
Copyright (c) 2025 Oleksandr Tishchenko / Marketing America Corp
*/
namespace App\Domain\Interfacing\Demo;

use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 */

/**
 *
 */
final readonly class DemoUserProfileInput
{
    /**
     * @param string $name
     * @param string $email
     */
    public function __construct(
        #[Assert\NotBlank(message: 'Name is required.')]
        #[Assert\Length(max: 80, maxMessage: 'Name must be at most {{ limit }} characters.')]
        public string $name,

        #[Assert\NotBlank(message: 'Email is required.')]
        #[Assert\Email(message: 'Email must be a valid email address.')]
        #[Assert\Length(max: 120, maxMessage: 'Email must be at most {{ limit }} characters.')]
        public string $email,
    ) {
    }
}
