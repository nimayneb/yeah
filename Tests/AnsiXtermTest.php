<?php

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
use JBR\AnsiHelper\Renditions;
use JBR\AnsiHelper\XtermScreen;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class AnsiXTermTest extends TestCase
{
    /**
     * @var XtermScreen
     */
    protected $screen;

    /**
     * @var array
     */
    protected $colors = [
        Color::DARK_RED,
        Color::RED,
        Color::PINK,
        Color::DARK_PINK,
        Color::DARK_BLUE,
        Color::BLUE,
        Color::DARK_CYAN,
        Color::CYAN,
        Color::DARK_GREEN,
        Color::GREEN,
        Color::DARK_YELLOW,
        Color::YELLOW,
        Color::WHITE,
        Color::GRAY,
        Color::DARK_GRAY,
        Color::BLACK,
    ];

    /**
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->screen = new XtermScreen();
        $this->screen->getRenditions()->setForegroundColor(Color::RED);
    }

    /**
     * @return void
     */
    public function testForegroundVisibility()
    {
        $renditions = Renditions::get();

        for ($i = 0; $i < 64; $i++) {
            if (1 === ($i & 1)) {
                $renditions->dim();
            }

            if (2 === ($i & 2)) {
                $renditions->bold();
            }

            if (4 === ($i & 4)) {
                $renditions->underline();
            }

            if (8 === ($i & 8)) {
                $renditions->blink();
            }

            if (16 === ($i & 16)) {
                $renditions->inverse();
            }

            if (32 === ($i & 32)) {
                $renditions->conceal();
            }

            $this->screen->newLine();
            $this->echoForegroundVisibility($renditions);
            $renditions->reset();
        }
    }

    /**
     * @return void
     */
    public function testBackgroundVisibility()
    {
        $renditions = Renditions::get();

        for ($i = 0; $i < 64; $i++) {
            if (1 === ($i & 1)) {
                $renditions->dim();
            }

            if (2 === ($i & 2)) {
                $renditions->bold();
            }

            if (4 === ($i & 4)) {
                $renditions->underline();
            }

            if (8 === ($i & 8)) {
                $renditions->blink();
            }

            if (16 === ($i & 16)) {
                $renditions->inverse();
            }

            if (32 === ($i & 32)) {
                $renditions->conceal();
            }

            $this->screen->newLine();
            $this->echoBackgroundVisibility($renditions);
            $renditions->reset();
        }
    }

    /**
     * @param RenditionsInterface $renditions
     *
     * @return void
     */
    public function echoForegroundVisibility(RenditionsInterface $renditions)
    {
        foreach ($this->colors as $color) {
            $this->echoForegroundColor($renditions, $color);
        }
    }

    /**
     * @param RenditionsInterface $renditions
     *
     * @return void
     */
    public function echoBackgroundVisibility(RenditionsInterface $renditions)
    {
        foreach ($this->colors as $color) {
            $this->echoBackgroundColor($renditions, $color);
        }
    }

    /**
     * @param RenditionsInterface $renditions
     * @param string $color
     *
     * @return void
     */
    private function echoForegroundColor(RenditionsInterface $renditions, $color)
    {
        $this->screen->text('This is foreground ');
        $attributes = $renditions->getAttributes();
        unset($attributes[Renditions::FOREGROUND_COLOR]);
        unset($attributes[Renditions::BACKGROUND_COLOR]);

        $renditions->setForegroundColor($color);
        $this->screen->textBlock(
            sprintf('%s with %s', $color, implode(', ', array_keys($attributes))?:"nothing"),
            $renditions
        );
        $this->screen->text(sprintf(' (%s with %s)!', $color, implode(', ', array_keys($attributes))?:"nothing"))
            ->newLine();
    }

    /**
     * @param RenditionsInterface $renditions
     * @param string $color
     *
     * @return void
     */
    private function echoBackgroundColor(RenditionsInterface $renditions, $color)
    {
        $this->screen->text('This is background ');
        $attributes = $renditions->getAttributes();
        unset($attributes[Renditions::FOREGROUND_COLOR]);
        unset($attributes[Renditions::BACKGROUND_COLOR]);

        $renditions->setBackgroundColor($color);
        $this->screen->textBlock(
            sprintf('%s with %s', $color, implode(', ', array_keys($attributes))?:"nothing"),
            $renditions
        );
        $this->screen->text(sprintf(' (%s with %s)!', $color, implode(', ', array_keys($attributes))?:"nothing"))
            ->newLine();
    }
}