<?php

require 'Classes/Models/ValueObject.php';

function getColorFromConsole(int $colorName): ValueObject
{
    $red = (int) readline("Введіть значення червоного кольору для $colorName: ");
    $green = (int) readline("Введіть значення зеленого кольору для $colorName: ");
    $blue = (int) readline("Введіть значення синього кольору для $colorName: ");
    return new ValueObject($red, $green, $blue);
}

$color1 = getColorFromConsole('color1');
$color2 = getColorFromConsole('color2');
$color3 = getColorFromConsole('color3');

$mixedColor = $color1->mix($color2);
echo "Змішаний колір:\n";
echo "Червоний: " . $mixedColor->getRed() . "\n";
echo "Зелений: " . $mixedColor->getGreen() . "\n";
echo "Синій: " . $mixedColor->getBlue() . "\n";

$randomColor = ValueObject::random();
echo "Випадковий колір:\n";
echo "Червоний: " . $randomColor->getRed() . "\n";
echo "Зелений: " . $randomColor->getGreen() . "\n";
echo "Синій: " . $randomColor->getBlue() . "\n";

echo "Колір 1 дорівнює кольору 3? ";
echo $color1->equals($color3) ? "так\n" : "ні\n";
