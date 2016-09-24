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

/**
 *
 */
class Color
{
    const DEFAULT_FOREGROUND_COLOR = 39;

    const DEFAULT_BACKGROUND_COLOR = 49;

    const DEFAULT_COLOR = 'default';

    const WHITE = 'white';

    const GRAY = 'gray';

    const DARK_GRAY = 'darkGray';

    const BLACK = 'black';

    const RED = 'red';

    const DARK_RED = 'darkRed';

    const GREEN = 'green';

    const DARK_GREEN = 'darkGreen';

    const YELLOW = 'yellow';

    const DARK_YELLOW = 'darkYellow';

    const BLUE = 'blue';

    const DARK_BLUE = 'darkBlue';

    const PINK = 'pink';

    const DARK_PINK = 'darkPink';

    const MAGENTA = 'magenta';

    const DARK_MAGENTA = 'darkMagenta';

    const CYAN = 'cyan';

    const DARK_CYAN = 'darkCyan';

    /**
     * @var array
     */
    protected static $foregroundColor = [
        self::DEFAULT_COLOR => self::DEFAULT_FOREGROUND_COLOR,
        self::BLACK => 30,
        self::DARK_RED => 31,
        self::DARK_GREEN => 32,
        self::DARK_YELLOW => 33,
        self::DARK_BLUE => 34,
        self::DARK_PINK => 35,
        self::DARK_MAGENTA => 35,
        self::DARK_CYAN => 36,
        self::GRAY => 37,
        self::DARK_GRAY => 90,
        self::RED => 91,
        self::GREEN => 92,
        self::YELLOW => 93,
        self::BLUE => 94,
        self::PINK => 95,
        self::MAGENTA => 95,
        self::CYAN => 96,
        self::WHITE => 97,
    ];

    /**
     * @var array
     */
    protected static $backgroundColor = [
        self::DEFAULT_COLOR => self::DEFAULT_BACKGROUND_COLOR,
        self::BLACK => 40,
        self::DARK_RED => 41,
        self::DARK_GREEN => 42,
        self::DARK_YELLOW => 43,
        self::DARK_BLUE => 44,
        self::DARK_PINK => 45,
        self::DARK_MAGENTA => 45,
        self::DARK_CYAN => 46,
        self::GRAY => 47,
        self::DARK_GRAY => 100,
        self::RED => 101,
        self::GREEN => 102,
        self::YELLOW => 103,
        self::BLUE => 104,
        self::PINK => 105,
        self::MAGENTA => 105,
        self::CYAN => 106,
        self::WHITE => 107,
    ];

    /**
     * @param string $colorName
     *
     * @return bool
     */
    public static function hasBackgroundColor($colorName)
    {
        return (TRUE === isset(static::$backgroundColor[$colorName]));
    }

    /**
     * @param string $colorName
     *
     * @return bool
     */
    public static function hasForegroundColor($colorName)
    {
        return (TRUE === isset(static::$foregroundColor[$colorName]));
    }

    /**
     * @param string $colorName
     *
     * @return mixed
     * @throws AnsiException
     */
    public static function getForegroundColor($colorName)
    {
        if (FALSE === isset(static::$foregroundColor[$colorName])) {
            throw new AnsiException(sprintf('Unknown foreground color <%s>', $colorName));
        }

        return static::$foregroundColor[$colorName];
    }

    /**
     * @param string $colorName
     *
     * @return mixed
     * @throws AnsiException
     */
    public static function getBackgroundColor($colorName)
    {
        if (FALSE === isset(static::$backgroundColor[$colorName])) {
            throw new AnsiException(sprintf('Unknown background color <%s>', $colorName));
        }

        return static::$backgroundColor[$colorName];
    }
}