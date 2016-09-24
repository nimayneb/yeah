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
class UnixXterm implements DetectorInterface
{
    /**
     * @throws AnsiException
     * @return void
     */
    public function detectWidth()
    {
        $result = exec('tput cols', $output, $errorLevel);

        if (static::RETURN_OKAY !== $errorLevel) {
            throw new AnsiException('Cannot get screen width!');
        }

        $this->width = intval($result);
    }

    /**
     * @throws AnsiException
     * @return void
     */
    public function detectHeight()
    {
        $result = exec('tput lines', $output, $errorLevel);

        if (static::RETURN_OKAY !== $errorLevel) {
            throw new AnsiException('Cannot get screen height!');
        }

        $this->height = intval($result);
    }

    /**
     * @param integer $width
     *
     * @throws AnsiException
     * @return void
     */
    public function setWidth($width) {
        $result = exec(sprintf('stty cols %u', $width), $output, $errorLevel);

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
        $result = exec(sprintf('stty rows %u', $height), $output, $errorLevel);

        if (static::RETURN_OKAY !== $errorLevel) {
            throw new AnsiException('Cannot set screen height!');
        }

        $this->height = intval($result);
    }

    /**
     * @return void
     */
    public function detectColumn()
    {
        // TODO: Implement detectColumn() method.
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