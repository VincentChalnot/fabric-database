<?php

namespace FabricDatabase\EAVModelBundle\Twig;

/**
 * Translate color names
 */
class ColorExtension extends \Twig_Extension
{
    /** @var array */
    protected $colorNames;

    /**
     * @param array $colorChoices
     */
    public function __construct(array $colorChoices)
    {
        $this->colorNames = array_flip($colorChoices);
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('color_name', [$this, 'getColorName']),
        ];
    }

    /**
     * @param string $colorCode
     *
     * @return string
     */
    public function getColorName($colorCode)
    {
        if (array_key_exists($colorCode, $this->colorNames)) {
            return $this->colorNames[$colorCode];
        }

        return '#'.$colorCode;
    }
}
