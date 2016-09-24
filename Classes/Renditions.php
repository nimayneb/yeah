<?php namespace JBR\AnsiHelper;

/************************************************************************************
 * Copyright (c) 2016, Jan Runte
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * 1. Redistributions  of source code must retain the above copyright notice,  this
 * list of conditions and the following disclaimer.
 *
 * 2. Redistributions  in  binary  form  must  reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation and/or
 * other materials provided with the distribution.
 *
 * THIS  SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY  EXPRESS OR IMPLIED WARRANTIES,  INCLUDING, BUT NOT LIMITED TO, THE  IMPLIED
 * WARRANTIES  OF  MERCHANTABILITY  AND   FITNESS  FOR  A  PARTICULAR  PURPOSE  ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 * ANY  DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL  DAMAGES
 * (INCLUDING,  BUT  NOT LIMITED TO,  PROCUREMENT OF SUBSTITUTE GOODS  OR  SERVICES;
 * LOSS  OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND  ON
 * ANY  THEORY  OF  LIABILITY,  WHETHER  IN  CONTRACT,  STRICT  LIABILITY,  OR TORT
 * (INCLUDING  NEGLIGENCE OR OTHERWISE)  ARISING IN ANY WAY OUT OF THE USE OF  THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 ************************************************************************************/

use JBR\AnsiHelper\Container\Color;
use JBR\AnsiHelper\Interfaces\RenditionsInterface;

/**
 *
 */
class Renditions implements RenditionsInterface
{

    const BLINK = 'blink';

    const DIM = 'dim';

    const BOLD = 'bold';

    const INVERSE = 'inverse';

    const CONCEAL = 'conceal';

    const UNDERLINE = 'underline';

    const BACKGROUND_COLOR = 'backgroundColor';

    const FOREGROUND_COLOR = 'foregroundColor';

    /**
     * @var bool
     */
    protected $blink = false;

    /**
     * @var bool
     */
    protected $dim = false;

    /**
     * @var bool
     */
    protected $bold = false;

    /**
     * @var bool
     */
    protected $underline = false;

    /**
     * @var bool
     */
    protected $inverse = false;

    /**
     * @var bool
     */
    protected $conceal = false;

    /**
     * @var string
     */
    protected $backgroundColor = Color::DEFAULT_COLOR;

    /**
     * @var string
     */
    protected $foregroundColor = Color::DEFAULT_COLOR;

    /**
     * @var string
     */
    private $attributesHash;

    /**
     *
     */
    private function __construct()
    {
        $this->attributesHash = $this->getAttributesHash();
    }

    /**
     * @param array $attributes
     *
     * @return string
     */
    private function getAttributesHash(array $attributes = null)
    {
        if (true === empty($attributes)) {
            $attributes = $this->getObjectAttributes($this);
        }

        return md5(serialize($attributes));
    }

    /**
     * @return boolean
     */
    public function isUnderline()
    {
        return $this->underline;
    }

    /**
     * @return RenditionsInterface
     */
    public function underline()
    {
        $this->underline = true;

        return $this;
    }

    /**
     * @return RenditionsInterface
     */
    public function noUnderline()
    {
        $this->underline = false;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isInverse()
    {
        return $this->inverse;
    }

    /**
     * @return RenditionsInterface
     */
    public function inverse()
    {
        $this->inverse = true;

        return $this;
    }

    /**
     * @return RenditionsInterface
     */
    public function reverse()
    {
        $this->inverse = false;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isConceal()
    {
        return $this->conceal;
    }

    /**
     * @return RenditionsInterface
     */
    public function conceal()
    {
        $this->conceal = true;

        return $this;
    }

    /**
     * @return RenditionsInterface
     */
    public function reveal()
    {
        $this->conceal = false;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isDim()
    {
        return $this->dim;
    }

    /**
     * @return RenditionsInterface
     */
    public function dim()
    {
        $this->dim = true;

        return $this;
    }

    /**
     * @return RenditionsInterface
     */
    public function unDim()
    {
        $this->dim = false;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isBlink()
    {
        return $this->blink;
    }

    /**
     * @return RenditionsInterface
     */
    public function blink()
    {
        $this->blink = true;

        return $this;
    }

    /**
     * @return RenditionsInterface
     */
    public function unBlink()
    {
        $this->blink = false;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isBold()
    {
        return $this->bold;
    }

    /**
     * @return RenditionsInterface
     */
    public function bold()
    {
        $this->bold = true;

        return $this;
    }

    /**
     * @return RenditionsInterface
     */
    public function unBold()
    {
        $this->bold = false;

        return $this;
    }

    /**
     * @return string
     */
    public function getForegroundColor()
    {
        return $this->foregroundColor;
    }

    /**
     * @param string $colorName
     *
     * @return RenditionsInterface
     */
    public function setForegroundColor($colorName)
    {
        $this->foregroundColor = $colorName;

        return $this;
    }

    /**
     * @return string
     */
    public function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    /**
     * @param string $colorName
     *
     * @return RenditionsInterface
     */
    public function setBackgroundColor($colorName)
    {
        $this->backgroundColor = $colorName;

        return $this;
    }

    /**
     * @param RenditionsInterface $childSettings
     *
     * @TODO: problematicly - unbold has no effect if bold is the single rendition (exp. foreground)
     *
     * @throws AnsiException
     * @return array
     */
    public function revertAttributesFrom(RenditionsInterface $childSettings)
    {
        if ($this === $childSettings) {
            throw new AnsiException('Cannot revert attributes from own.');
        }

        $originAttributes = $this->getObjectAttributes($this);
        $attributes = $this->getObjectAttributes($childSettings);

        $revertAttributes = [];

        foreach ($attributes as $attribute => $value) {
            if ($originAttributes[$attribute] === $value) {
                continue;
            }

            $revertAttributes[$attribute] = $originAttributes[$attribute];
        }

        return $revertAttributes;
    }

    /**
     * @param RenditionsInterface $parentSettings
     *
     * @throws AnsiException
     * @return array
     */
    public function getAttributes(RenditionsInterface $parentSettings = null)
    {
        if ($this === $parentSettings) {
            throw new AnsiException('Cannot get attributes from own.');
        }

        $attributes = $this->getObjectAttributes($this);

        if (null !== $parentSettings) {
            $parentAttributes = $this->getObjectAttributes($parentSettings);
            $diffAttributes = [];

            foreach ($attributes as $attribute => $value) {
                if (
                    (
                        (true === isset($parentAttributes[$attribute]))
                        && ($parentAttributes[$attribute] === $value)
                    ) || (true === empty($value))
                ) {
                    continue;
                }

                $diffAttributes[$attribute] = $value;
            }

            $attributes = $diffAttributes;
        } else {
            $attributes = array_filter($attributes);
        }

        return $attributes;
    }

    /**
     * This method returns only one times a true value, after the next call it returns a false value.
     * If attributes has been changed it returns true again.
     *
     * @return boolean
     */
    public function hasChanged()
    {
        $oldHash = $this->attributesHash;
        $hash = $this->getAttributesHash();
        $this->attributesHash = $hash;

        return ($hash !== $oldHash);
    }

    /**
     * @param RenditionsInterface $object
     * @return array
     */
    private function getObjectAttributes(RenditionsInterface $object)
    {
        $attributes = get_object_vars($object);
        unset($attributes['attributesHash']);

        return $attributes;
    }

    /**
     * @return RenditionsInterface
     */
    public function reset()
    {
        $this->dim = false;
        $this->blink = false;
        $this->underline = false;
        $this->conceal = false;
        $this->inverse = false;
        $this->bold = false;
        $this->backgroundColor = Color::DEFAULT_COLOR;
        $this->foregroundColor = Color::DEFAULT_COLOR;

        Sequencer::resetAttributeModes();

        $this->attributesHash = $this->getAttributesHash();

        return $this;
    }

    /**
     * @return RenditionsInterface
     */
    public static function get()
    {
        return new self();
    }
}