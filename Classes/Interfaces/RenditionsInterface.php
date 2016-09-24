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

/**
 *
 */
interface RenditionsInterface extends RenditionsAttributesInterface
{
    /**
     * @return boolean
     */
    public function isUnderline();

    /**
     * @return RenditionsInterface
     */
    public function underline();

    /**
     * @return RenditionsInterface
     */
    public function noUnderline();

    /**
     * @return boolean
     */
    public function isInverse();

    /**
     * @return RenditionsInterface
     */
    public function inverse();

    /**
     * @return RenditionsInterface
     */
    public function reverse();

    /**
     * @return boolean
     */
    public function isConceal();

    /**
     * @return RenditionsInterface
     */
    public function conceal();

    /**
     * @return RenditionsInterface
     */
    public function reveal();

    /**
     * @return boolean
     */
    public function isDim();

    /**
     * @return RenditionsInterface
     */
    public function dim();

    /**
     * @return RenditionsInterface
     */
    public function unDim();

    /**
     * @return boolean
     */
    public function isBlink();

    /**
     * @return RenditionsInterface
     */
    public function blink();

    /**
     * @return RenditionsInterface
     */
    public function unBlink();

    /**
     * @return boolean
     */
    public function isBold();

    /**
     * @return RenditionsInterface
     */
    public function bold();

    /**
     * @return RenditionsInterface
     */
    public function unBold();

    /**
     * @return string
     */
    public function getForegroundColor();

    /**
     * @param string $colorName
     *
     * @return RenditionsInterface
     */
    public function setForegroundColor($colorName);

    /**
     * @return string
     */
    public function getBackgroundColor();

    /**
     * @param string $colorName
     *
     * @return RenditionsInterface
     */
    public function setBackgroundColor($colorName);
}