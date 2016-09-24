<?php namespace JBR\AnsiHelper\Interfaces;

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
interface ScreenInterface
{
    const BACKSPACE = 8;

    const TABULATOR = 9;

    const LINE_FEED = 10;

    const VERTICAL_TABULATOR = 11;

    const FORM_FEED = 12;

    const CARRIAGE_RETURN = 13;

    /**
     * @param integer $width
     *
     * @throws AnsiException
     * @return void
     */
    public function setWidth($width);

    /**
     * @param integer $height
     *
     * @throws AnsiException
     * @return void
     */
    public function setHeight($height);

    /**
     * @return integer
     */
    public function getWidth();

    /**
     * @return integer
     */
    public function getHeight();

    /**
     * @return CursorInterface
     */
    public function getCursor();

    /**
     * @return RenditionsInterface
     */
    public function getRenditions();

    /**
     * @return ScreenInterface
     */
    public function newLine();

    /**
     * @return ScreenInterface
     */
    public function firstColumn();

    /**
     * @return ScreenInterface
     */
    public function backspace();

    /**
     * @param string $content
     *
     * @return ScreenInterface
     * @throws AnsiException
     */
    public function text($content);

    /**
     * @param string $content
     * @param RenditionsInterface $renditions
     *
     * @return ScreenInterface
     */
    public function textBlock($content, RenditionsInterface $renditions);

    /**
     * @param string $content
     *
     * @return ScreenInterface
     * @throws AnsiException
     */
    public function textLine($content);
}