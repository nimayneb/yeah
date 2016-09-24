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
interface CursorInterface
{
    /**
     * @param integer $column
     *
     * @return boolean
     */
    public function setColumn($column);

    /**
     * @param integer $row
     *
     * @return boolean
     */
    public function setRow($row);

    /**
     * Only use it to set column when a previous output was flushed.
     * Returns true if a new value was set.
     *
     * @param integer $column
     *
     * @return boolean
     */
    public function setInternalColumn($column);

    /**
     * Only use it to set row when a previous output was flushed.
     * Returns true if a new value was set.
     *
     * @param integer $row
     *
     * @return boolean
     */
    public function setInternalRow($row);

    /**
     * @return void
     */
    public function firstColumn();

    /**
     * @return void
     */
    public function firstRow();

    /**
     * @param integer $columnSet
     *
     * @return CursorInterface
     */
    public function left($columnSet);

    /**
     * @param integer $columnSet
     *
     * @return CursorInterface
     */
    public function right($columnSet);

    /**
     * @param integer $rowSet
     *
     * @return CursorInterface
     */
    public function up($rowSet);

    /**
     * @param integer $rowSet
     *
     * @return CursorInterface
     */
    public function down($rowSet);

    /**
     * @param integer $row
     *
     * @return CursorInterface
     */
    public function toRow($row);

    /**
     * @param integer $column
     *
     * @return CursorInterface
     */
    public function toColumn($column);

    /**
     * @return int
     */
    public function getRow();

    /**
     * @return int
     */
    public function getColumn();

    /**
     * @param integer $column
     * @param integer $row
     *
     * @return CursorInterface
     */
    public function toPosition($column, $row);
}