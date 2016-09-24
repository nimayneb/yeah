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
use JBR\AnsiHelper\Container\GraphicRendition;
use JBR\AnsiHelper\Container\Sequence;
use JBR\AnsiHelper\Interfaces\RenditionsInterface;

/**
 *
 */
class Sequencer
{
    /*
     * CLEAR SCREEN
     */

    /**
     * Clears from cursor to end of screen.
     *
     * ANSI.SYS: Moves cursor to upper left.
     *
     * @param int $x
     * @param int $y
     *
     * @return string
     */
    public static function clearScreen($x = 0, $y = 0)
    {
        $clearScreen = self::command(Sequence::ERASE_SCREEN);
        $resetCursor = self::cursor($x, $y);

        return $clearScreen . $resetCursor;
    }

    /**
     * Clears entire screen.
     *
     * ANSI.SYS: Moves cursor to upper left.
     *
     * @return string
     */
    public static function clearBottomScreenFromCursor()
    {
        return self::command(Sequence::ERASE_SCREEN_BOTTOM);
    }

    /**
     * Clears from cursor to beginning of the screen.
     *
     * ANSI.SYS: Moves cursor to upper left.
     *
     * @return string
     */
    public static function clearTopScreenFromCursor()
    {
        return self::command(Sequence::ERASE_SCREEN_TOP);
    }

    /*
     * ERASE LINE
     */

    /**
     * Clears entire line. Cursor position does not change.
     *
     * @return string
     */
    public static function eraseLine()
    {
        return self::command(Sequence::ERASE_LINE);
    }

    /**
     * Clears from cursor to the end of the line.
     * Cursor position does not change.
     *
     * @return string
     */
    public static function eraseRightFromCursor()
    {
        return self::command(Sequence::ERASE_END_OF_LINE);
    }

    /**
     * Clears from cursor to beginning of the line.
     * Cursor position does not change.
     *
     * @return string
     */
    public static function eraseLeftFromCursor()
    {
        return self::command(Sequence::ERASE_START_OF_LINE);
    }

    /*
     * CURSOR POSITIONS
     */

    /**
     * @param int $column
     *
     * @return string
     */
    public static function cursorToColumn($column)
    {
        return self::command(sprintf(Sequence::CURSOR_POSITION_COLUMN, $column));
    }

    /**
     * @param int $row
     *
     * @return string
     */
    public static function cursorToRow($row)
    {
        return self::command(sprintf(Sequence::CURSOR_POSITION_ROW, $row));
    }

    /**
     * @param int $x
     * @param int $y
     *
     * @return string
     */
    public static function cursor($x, $y)
    {
        return self::command(sprintf(Sequence::CURSOR_POSITION, $x, $y));
    }

    /**
     * @return string
     */
    public static function home()
    {
        return self::command(Sequence::CURSOR_POSITION_HOME);
    }

    /**
     * Moves cursor to beginning of the line {\displaystyle n} n (default 1) lines down. (not ANSI.SYS)
     *
     * @param int $steps
     *
     * @return string
     */
    public static function nextLine($steps = 1)
    {
        return self::command(sprintf(Sequence::CURSOR_NEXT_LINE, $steps));
    }

    /**
     * Moves cursor to beginning of the line n (default 1) lines up. (not ANSI.SYS)
     *
     * @param int $steps
     *
     * @return string
     */
    public static function previousLine($steps = 1)
    {
        return self::command(sprintf(Sequence::CURSOR_PREVIOUS_LINE, $steps));
    }

    /**
     * Moves the cursor n cells in the given direction.
     * If the cursor is already at the edge of the screen, this has no effect.
     *
     * @param integer $steps
     * @return string
     */
    public static function forward($steps)
    {
        return self::command(sprintf(Sequence::CURSOR_FORWARD, $steps));
    }

    /**
     * Moves the cursor n cells in the given direction.
     * If the cursor is already at the edge of the screen, this has no effect.
     *
     * @param integer $steps
     * @return string
     */
    public static function backward($steps)
    {
        return self::command(sprintf(Sequence::CURSOR_BACKWARD, $steps));
    }

    /**
     * Moves the cursor n cells in the given direction.
     * If the cursor is already at the edge of the screen, this has no effect.
     *
     * @param integer $steps
     * @return string
     */
    public static function up($steps)
    {
        return self::command(sprintf(Sequence::CURSOR_UP, $steps));
    }

    /**
     * Moves the cursor n cells in the given direction.
     * If the cursor is already at the edge of the screen, this has no effect.
     *
     * @param integer $steps
     * @return string
     */
    public static function down($steps)
    {
        return self::command(sprintf(Sequence::CURSOR_DOWN, $steps));
    }

    /*
     * CURSOR VISIBILITY
     */

    /**
     * Hides the cursor.
     *
     * @return string
     */
    public static function hide()
    {
        return self::command(Sequence::CURSOR_HIDE);
    }

    /**
     * Shows the cursor.
     *
     * @return string
     */
    public static function show()
    {
        return self::command(Sequence::CURSOR_SHOW);
    }

    /*
     * STORE POSITIONS
     */

    /**
     * Saves the cursor position.
     *
     * @return string
     */
    public static function savePosition()
    {
        return self::command(Sequence::CURSOR_SAVE_POSITION);
    }

    /**
     * Restores the cursor position.
     *
     * @return string
     */
    public static function restorePosition()
    {
        return self::command(Sequence::CURSOR_RESTORE_POSITION);
    }

    /*
     * COLORS
     */

    /**
     * @param string $colorName
     * @param Renditions $settings
     *
     * @return string
     */
    public static function setBackgroundColorCommand($colorName, Renditions $settings = null)
    {
        if (null !== $settings) {
            $settings->setBackgroundColor($colorName);
        }

        return self::attributeRenditionCommand(0, Color::getBackgroundColor($colorName));
    }

    /**
     * @param string $colorName
     * @param Renditions $settings
     *
     * @return string
     */
    public static function setForegroundColorCommand($colorName, Renditions $settings = null)
    {
        if (null !== $settings) {
            $settings->setBackgroundColor($colorName);
        }

        return self::attributeRenditionCommand(0, Color::getForegroundColor($colorName));
    }

    /*
     * COMMANDS
     */

    /**
     * @param $command
     *
     * @return string
     */
    public static function command($command)
    {
        return Sequence::ESCAPE . $command;
    }

    /**
     * @return string
     */
    public static function resetAttributeModes()
    {
        return self::command(Sequence::ATTRIBUTE_MODES_RESET);
    }

    /**
     * @param array $attributes
     *
     * @return string
     */
    public static function attributesCommand(array $attributes)
    {
        $output = '';

        if (0 < count($attributes)) {
            $renditions = implode(';', GraphicRendition::getFrom($attributes));
            $output = self::command(sprintf(Sequence::ATTRIBUTE_MODES_SET, $renditions));
        }

        return $output;
    }


    /**
     * @param RenditionsInterface $renditions
     * @param RenditionsInterface $parentSettings
     *
     * @return string
     */
    public static function attributeRenditionsCommand(RenditionsInterface $renditions, RenditionsInterface $parentSettings = null)
    {
        $output = '';
        $attributes = $renditions->getAttributes($parentSettings);

        if (0 < count($attributes)) {
            $output = self::command(sprintf(Sequence::ATTRIBUTE_MODES_SET, implode(';', $attributes)));
        }

        return $output;
    }

    /**
     * @param int $rendition
     * @param int $attribute
     *
     * @return string
     */
    public static function attributeRenditionCommand($rendition, $attribute)
    {
        return self::command(sprintf(Sequence::ATTRIBUTE_RENDITION_SET, $rendition, $attribute));
    }
}