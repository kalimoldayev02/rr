<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

final readonly class EmailVO implements \Stringable
{
    private string $value;

    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getLocalPart(): string
    {
        return \explode('@', $this->value)[0];
    }

    public function getDomain(): string
    {
        return \explode('@', $this->value)[1];
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->getValue();
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function validate(string $email): void
    {
        if (!\filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(
                \sprintf("'%s' is not a valid email address", $email),
            );
        }
    }
}
