<?php

class ValueObject {
    private int $red;
    private int $green;
    private int $blue;

    public function __construct(int $red, int $green, int $blue)
    {
        $this->setRed($red);
        $this->setGreen($green);
        $this->setBlue($blue);
    }

    public function getRed(): int
    {
        return $this->red;
    }

    public function setRed(int $red): void
    {
        if (!$this->isValidColorNum($red)) {
            throw new InvalidArgumentException("Значення червоного кольору мають бути в діапазоні від 0 до 255\n");
        }

        $this->red = $red;
    }

    public function getGreen(): int
    {
        return $this->green;
    }

    public function setGreen(int $green): void
    {
        if (!$this->isValidColorNum($green)) {
            throw new InvalidArgumentException("Значення зеленого кольору мають бути в діапазоні від 0 до 255\n");
        }

        $this->green = $green;
    }

    public function getBlue(): int
    {
        return $this->blue;
    }

    public function setBlue(int $blue): void
    {
        if (!$this->isValidColorNum($blue)) {
            throw new InvalidArgumentException("Значення синього кольору мають бути в діапазоні від 0 до 255\n");
        }

        $this->blue = $blue;
    }

    private function isValidColorNum(int $num): bool
    {
        if ($num < 0 || $num > 255) {
            return false;
        }

        return true;
    }

    public function equals(ValueObject $color): bool
    {
        return $this->getRed() === $color->getRed() &&
               $this->getGreen() === $color->getGreen() &&
               $this->getBlue() === $color->getBlue();
    }

    public static function random(): ValueObject
    {
        return new self(rand(0, 255), rand(0, 255), rand(0, 255));
    }

    public function mix(ValueObject $color): ValueObject
    {
        $mixedRed = intval(($this->getRed() + $color->getRed()) / 2);
        $mixedGreen = intval(($this->getGreen() + $color->getGreen()) / 2);
        $mixedBlue = intval(($this->getBlue() + $color->getBlue()) / 2);
        return new self($mixedRed, $mixedGreen, $mixedBlue);
    }
}
