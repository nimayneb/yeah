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

use JBR\AnsiHelper\Container\Sequence;
use JBR\AnsiHelper\Interfaces\CursorInterface;
use JBR\AnsiHelper\Interfaces\RenditionsInterface;
use JBR\AnsiHelper\Interfaces\ScreenInterface;

/**
 *
 */
abstract class Screen implements ScreenInterface
{
    /**
     * @var integer
     */
    protected $width;

    /**
     * @var integer
     */
    protected $height;

    /**
     * @var CursorInterface
     */
    protected $cursor;

    /**
     * @var RenditionsInterface
     */
    protected $renditions;

    /**
     * @param integer $width
     * @param integer $height
     * @param integer $column
     * @param integer $row
     * @param CursorInterface $cursor
     * @param RenditionsInterface $renditions
     */
    public function __construct(
        $width = null,
        $height = null,
        $column = 0,
        $row = 0,
        CursorInterface $cursor = null,
        RenditionsInterface $renditions = null
    ) {
        $this->injectCursor($cursor);
        $this->injectRenditions($renditions);

        $detector = Detector::get($this);
        $detector->process($width, $height, $column, $row);
    }

    /**
     * @param RenditionsInterface $renditions
     *
     * @return void
     */
    private function injectRenditions($renditions)
    {
        $this->renditions = ($renditions)?:Renditions::get();
        Sequencer::attributeRenditionsCommand($this->renditions);
    }

    /**
     * @param CursorInterface $cursor
     *
     * @return void
     */
    private function injectCursor(CursorInterface $cursor = null)
    {
        $this->cursor = ($cursor)?:Cursor::get($this);
    }

    /**
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return CursorInterface
     */
    public function getCursor()
    {
        return $this->cursor;
    }

    /**
     * @return RenditionsInterface
     */
    public function getRenditions()
    {
        return $this->renditions;
    }

    /**
     * @return ScreenInterface
     */
    public function newLine()
    {
        if (true === $this->cursor->setInternalRow(1)) {
            $this->flushIfRenditionsHasChanged();

            echo chr(static::LINE_FEED);

            $this->cursor->firstColumn();
        }
    }

    /**
     * @return ScreenInterface
     */
    public function firstColumn()
    {
        $this->flushIfRenditionsHasChanged();

        echo chr(static::CARRIAGE_RETURN);

        $this->cursor->firstColumn();
    }

    /**
     * @return ScreenInterface
     */
    public function backspace()
    {
        if (true === $this->cursor->setInternalColumn(-1)) {
            $this->flushIfRenditionsHasChanged();

            echo chr(static::BACKSPACE);
        }
    }

    /**
     * @param string $content
     * @return bool
     */
    private function hasSequenceCharacters($content)
    {
        return (
            (false !== strpos($content, Sequence::ESCAPE))
            || (false !== strpos($content, chr(static::BACKSPACE)))
            || (false !== strpos($content, chr(static::TABULATOR)))
            || (false !== strpos($content, chr(static::LINE_FEED)))
            || (false !== strpos($content, chr(static::VERTICAL_TABULATOR)))
            || (false !== strpos($content, chr(static::FORM_FEED)))
            || (false !== strpos($content, chr(static::CARRIAGE_RETURN)))
        );
    }

    /**
     * @param string $content
     *
     * @return ScreenInterface
     * @throws AnsiException
     */
    public function text($content)
    {
        if (true === $this->hasSequenceCharacters($content)) {
            throw new AnsiException('Cannot flush sequence characters!');
        }

        if (true === $this->cursor->setInternalColumn(mb_strlen($content))) {
            $this->flushIfRenditionsHasChanged();

            echo $content;
        }

        return $this;
    }

    /**
     * @param string $content
     * @param RenditionsInterface $renditions
     *
     * @return ScreenInterface
     */
    public function textBlock($content, RenditionsInterface $renditions)
    {
        $attributes = $renditions->getAttributes($this->renditions);
        echo Sequencer::attributesCommand($attributes);

        $this->text($content);

        $revertAttributes = $this->renditions->revertAttributesFrom($renditions);
        echo Sequencer::attributesCommand($revertAttributes);

        return $this;
    }

    /**
     * @param string $content
     *
     * @return ScreenInterface
     * @throws AnsiException
     */
    public function textLine($content)
    {
        if (true === $this->hasSequenceCharacters($content)) {
            throw new AnsiException('Cannot flush sequence characters!');
        }

        $this->flushIfRenditionsHasChanged();

        echo $content;

        $this->newLine();

        return $this;
    }

    /**
     * @return void
     */
    private function flushIfRenditionsHasChanged()
    {
        if (true === $this->renditions->hasChanged()) {
            echo Sequencer::attributesCommand($this->renditions->getAttributes());
        }
    }
}