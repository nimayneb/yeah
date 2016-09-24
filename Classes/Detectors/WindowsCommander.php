<?php namespace JBR\AnsiHelper\Detectors;

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
use JBR\AnsiHelper\Interfaces\DetectorInterface;

/**
 *
 */
class WindowsCommander implements DetectorInterface
{
    const MODE_COM_ROWS_OUTPUT_LINE = 3;

    const MODE_COM_COLUMNS_OUTPUT_LINE = 4;

    /**
     * @return boolean
     */
    public function match()
    {
        // TODO: Implement match() method.
    }

    /**
     * @return integer
     */
    public function detectColumn()
    {
        $windows = (PHP_OS === 'WIN');
    }

    /**
     * @throws AnsiException
     * @return void
     */
    public function detectWidth()
    {
        exec('mode.com CON: 2>NUL', $output, $errorLevel);

        if (static::RETURN_OKAY !== $errorLevel) {
            throw new AnsiException('Cannot get screen width!');
        }

        $result = array_pop(explode(':', $output[static::MODE_COM_COLUMNS_OUTPUT_LINE]));
        $this->width = intval($result);
    }

    /**
     * @throws AnsiException
     * @return void
     */
    public function detectHeight()
    {
        exec('mode.com CON: 2>NUL', $output, $errorLevel);

        if (static::RETURN_OKAY !== $errorLevel) {
            throw new AnsiException('Cannot get screen height!');
        }

        $result = array_pop(explode(':', $output[static::MODE_COM_ROWS_OUTPUT_LINE]));
        $this->height = intval($result);
    }

    /**
     * @param integer $width
     *
     * @throws AnsiException
     * @return void
     */
    public function setWidth($width) {
        $result = exec(sprintf('mode.com CON: COLS=%u 2>NUL', $width), $output, $errorLevel);

        if (static::RETURN_OKAY !== $errorLevel) {
            throw new AnsiException('Cannot set screen width!');
        }

        $this->width = intval($result);
    }

    /**
     * @param integer $height
     *
     * @throws AnsiException
     * @return void
     */
    public function setHeight($height) {
        $result = exec(sprintf('mode.com CON: LINES=%u 2>NUL', $height), $output, $errorLevel);

        if (static::RETURN_OKAY !== $errorLevel) {
            throw new AnsiException('Cannot set screen height!');
        }

        $this->height = intval($result);
    }

    /**
     * @return void
     */
    public function detectRow()
    {
        // TODO: Implement detectRow() method.
    }

    /**
     * @param integer $column
     *
     * @return void
     */
    public function setColumn($column)
    {
        // TODO: Implement setColumn() method.
    }

    /**
     * @param integer $row
     *
     * @return void
     */
    public function setRow($row)
    {
        // TODO: Implement setRow() method.
    }
}