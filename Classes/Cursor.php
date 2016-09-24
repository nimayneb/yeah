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

use Exception;
use JBR\AnsiHelper\Interfaces\CursorInterface;
use JBR\AnsiHelper\Interfaces\ScreenInterface;

/**
 *
 */
class Cursor implements CursorInterface
{
    /**
     * @var ScreenInterface
     */
    protected $screen;

    /**
     * Column
     *
     * @var integer
     */
    protected $column;

    /**
     * Row
     *
     * @var integer
     */
    protected $row;

    /**
     * @param ScreenInterface $screen
     */
    private function __construct(ScreenInterface $screen)
    {
        $this->screen = $screen;
    }

    /**
     * @param integer $columnSet
     *
     * @throws AnsiException
     * @return CursorInterface
     */
    public function left($columnSet)
    {
        $this->column -= $columnSet;
        if (0 > $this->column) {
            throw new AnsiException('You cannot go outside the screen from current column!');
        }

        Sequencer::forward($columnSet);

        return $this;
    }

    /**
     * @param integer $columnSet
     *
     * @throws AnsiException
     * @return CursorInterface
     */
    public function right($columnSet)
    {
        $this->column += $columnSet;
        if ($this->screen->getWidth() < $columnSet) {
            throw new AnsiException(
                sprintf('It is not allowed to get bigger than <%u> columns.%u', $this->screen->getWidth(), $columnSet)
            );
        }

        if (4 < $columnSet) {
            Sequencer::backward($columnSet);
        } else {
            echo str_repeat(chr(ScreenInterface::BACKSPACE), $columnSet);
        }

        return $this;
    }

    /**
     * @param integer $rowSet
     *
     * @throws AnsiException
     * @return CursorInterface
     */
    public function up($rowSet)
    {
        $this->row -= $rowSet;
        if (0 > $this->column) {
            throw new AnsiException('You cannot go outside the screen from current row!');
        }

        Sequencer::up($rowSet);

        return $this;
    }

    /**
     * @param integer $rowSet
     *
     * @throws AnsiException
     * @return CursorInterface
     */
    public function down($rowSet)
    {
        $this->row += $rowSet;
        if ($this->screen->getHeight() < $rowSet) {
            throw new AnsiException(
                sprintf('It is not allowed to get bigger than <%u> rows.%u', $this->screen->getHeight(), $rowSet)
            );
        }

        if ((4 >= $rowSet) && (0 === $this->column)) {
            echo str_repeat(chr(ScreenInterface::LINE_FEED), $rowSet);
        } else {
            Sequencer::down($rowSet);
        }

        return $this;
    }

    /**
     * @param integer $row
     *
     * @return CursorInterface
     */
    public function toRow($row)
    {
        if ($this->row > $row) {
            $this->up($this->row - $row);
        } elseif ($this->row < $row) {
            $this->down($row - $this->row);
        }

        return $this;
    }

    /**
     * @param integer $column
     *
     * @return CursorInterface
     */
    public function toColumn($column)
    {
        if ($this->column > $column) {
            $this->left($this->column - $column);
        } elseif ($this->column < $column) {
            $this->right($column - $this->column);
        }

        return $this;
    }

    /**
     * @return void
     */
    public function lastColumn() {
        $this->toColumn($this->screen->getWidth());
    }

    /**
     * @return void
     */
    public function firstColumn() {
        $this->toColumn(0);
    }

    /**
     * @return void
     */
    public function firstRow() {
        $this->toRow(0);
    }

    /**
     * @return void
     */
    public function lastRow() {
        $this->toRow($this->screen->getHeight());
    }

    /**
     * @param integer $column
     *
     * @throws Exception
     * @return void
     */
    public function setColumn($column)
    {
        if ((0 <= $column) && ($this->screen->getWidth() < $column)) {
            throw new Exception(sprintf('Cannot go outside the screen width of <%u>%u', $this->screen->getWidth(), $column));
        }

        Sequencer::cursorToColumn($this->column = $column);
    }

    /**
     * @param integer $row
     *
     * @throws Exception
     * @return void
     */
    public function setRow($row)
    {
        if ((0 <= $row) && ($this->screen->getHeight() < $row)) {
            throw new Exception(sprintf('Cannot go outside the screen height of <%u>%u', $this->screen->getHeight(), $row));
        }

        Sequencer::cursorToRow($this->row = $row);
    }

    /**
     * @param integer $column
     *
     * @return boolean
     */
    public function setInternalColumn($column)
    {
        $oldColumn = $this->column;
        $this->column += $column;

        if ($this->column < 0) {
            $this->column = 0;
        }

        return ($oldColumn !== $this->column);
    }

    /**
     * @param integer $row
     *
     * @return boolean
     */
    public function setInternalRow($row)
    {
        $oldRow = $this->row;
        $this->row += $row;

        if ($this->row < 0) {
            $this->row = 0;
        }

        return ($oldRow !== $this->row);
    }

    /**
     * @return int
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * @return int
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * @param integer $column
     * @param integer $row
     *
     * @return CursorInterface
     */
    public function toPosition($column, $row)
    {
        if (($column === $this->column) && ($row !== $this->row)) {
            $this->toRow($row);
        } elseif (($column !== $this->column) && ($row === $this->row)) {
            $this->toColumn($column);
        } elseif (($column !== $this->column) && ($row !== $this->row)) {
            $this->column = $column;
            $this->row = $row;
            Sequencer::cursor($column, $row);
        }

        return $this;
    }

    /**
     * @param ScreenInterface $screen
     *
     * @return CursorInterface
     */
    public static function get(ScreenInterface $screen)
    {
        return new self($screen);
    }
}