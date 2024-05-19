<?php

class ValueObject {
    private $red;
    private $green;
    private $blue;

    public function __construct($red, $green, $blue) {
        $this->setRed($red);
        $this->setGreen($green);
        $this->setBlue($blue);
    }

    public function getRed() {
        return $this->red;
    }

    public function setRed($red) {
        if (!$this->isValidColorNum($red)) {
            throw new InvalidArgumentException("Значення червоного кольору мають бути в діапазоні від 0 до 255\n");
        }
        $this->red = $red;
    }

    public function getGreen() {
        return $this->green;
    }

    public function setGreen($green) {
        if (!$this->isValidColorNum($green)) {
            throw new InvalidArgumentException("Значення зеленого кольору мають бути в діапазоні від 0 до 255\n");
        }
        $this->green = $green;
    }

    public function getBlue() {
        return $this->blue;
    }

    public function setBlue($blue) {
        if (!$this->isValidColorNum($blue)) {
            throw new InvalidArgumentException("Значення синього кольору мають бути в діапазоні від 0 до 255\n");
        }
        $this->blue = $blue;
    }

    private function isValidColorNum($num) {
        if ($num < 0 || $num > 255) {
            return false;
        }

        return true;
    }

    public function equals(ValueObject $color) {
        return $this->getRed() === $color->getRed() &&
               $this->getGreen() === $color->getGreen() &&
               $this->getBlue() === $color->getBlue();
    }

    public static function random() {
        return new self(rand(0, 255), rand(0, 255), rand(0, 255));
    }

    public function mix(ValueObject $color) {
        $mixedRed = intval(($this->getRed() + $color->getRed()) / 2);
        $mixedGreen = intval(($this->getGreen() + $color->getGreen()) / 2);
        $mixedBlue = intval(($this->getBlue() + $color->getBlue()) / 2);
        return new self($mixedRed, $mixedGreen, $mixedBlue);
    }
}
