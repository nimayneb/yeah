<?php namespace JBR\AnsiHelper\Container;

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

use JBR\AnsiHelper\AnsiException;
use JBR\AnsiHelper\Renditions;

/**
 *
 */
class GraphicRendition
{

    const NORMAL = 0;

    /*
     * Set rendition
     */

    const BOLD = 1;

    const DIM = 2;

    const UNDERLINE = 4;

    const BLINK = 5;

    const SCREEN_INVERSE = 7;

    const CURSOR_CONCEAL = 8;

    /*
     * Reset rendition
     */

    const BOLD_NONE = 21;

    const DIM_NONE = 22;

    const UNDERLINE_NONE = 24;

    const BLINK_NONE = 25;

    const SCREEN_REVERSE = 27;

    const CURSOR_REVEAL = 28;

    /**
     * @var array
     */
    protected static $set = [
        Renditions::BOLD => self::BOLD,
        Renditions::DIM => self::DIM,
        Renditions::UNDERLINE => self::UNDERLINE,
        Renditions::BLINK => self::BLINK,
        Renditions::INVERSE => self::SCREEN_INVERSE,
        Renditions::CONCEAL => self::CURSOR_CONCEAL
    ];

    /**
     * @var array
     */
    protected static $reset = [
        Renditions::BOLD => self::BOLD_NONE,
        Renditions::DIM => self::DIM_NONE,
        Renditions::UNDERLINE => self::UNDERLINE_NONE,
        Renditions::BLINK => self::BLINK_NONE,
        Renditions::INVERSE => self::SCREEN_REVERSE,
        Renditions::CONCEAL => self::CURSOR_REVEAL
    ];

    /**
     * @param array $attributes
     *
     * @throws AnsiException
     * @return array
     */
    public static function getFrom(array $attributes)
    {
        $renditions = [];

        foreach ($attributes as $attribute => $value) {
            if (true === $value) {
                if (false === isset(static::$set[$attribute])) {
                    throw new AnsiException(sprintf('Cannot find set attribute <%s>!', $attribute));
                }

                $renditions[] = static::$set[$attribute];
            } elseif (false === $value) {
                if (false === isset(static::$reset[$attribute])) {
                    throw new AnsiException(sprintf('Cannot find reset attribute <%s>!', $attribute));
                }

                $renditions[] = static::$reset[$attribute];
            } elseif (Renditions::FOREGROUND_COLOR === $attribute) {
                if (null === $value) {
                    $renditions[] = Color::DEFAULT_FOREGROUND_COLOR;
                } else {
                    $renditions[] = Color::getForegroundColor($value);
                }
            } elseif (Renditions::BACKGROUND_COLOR === $attribute) {
                if (null === $value) {
                    $renditions[] = Color::DEFAULT_BACKGROUND_COLOR;
                } else {
                    $renditions[] = Color::getBackgroundColor($value);
                }
            }
        }

        return $renditions;
    }
}