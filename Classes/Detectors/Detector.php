<?php namespace JBR\AnsiHelper\Detectors;

use JBR\AnsiHelper\AnsiException;
use JBR\AnsiHelper\Interfaces\CursorInterface;
use JBR\AnsiHelper\Interfaces\ScreenInterface;

/**
 *
 */
class Detector
{
    /**
     * @param integer $width
     * @param integer $height
     * @param integer $column
     * @param integer $row
     */
    public function process($width, $height, $column, $row)
    {
        $this->detectAndSetSize($width, $height);
        $this->detectAndSetPosition($column, $row);
    }

    /**
     * @param integer $column
     * @param integer $row
     *
     * @throws AnsiException
     * @return void
     */
    protected function detectAndSetPosition($column, $row)
    {
        if (true !== empty($column)) {
            $this->setColumn($column);
        } else {
            $this->detectColumn();
        }

        if (true !== empty($row)) {
            $this->setRow($row);
        } else {
            $this->detectRow();
        }
    }

    /**
     * @param integer $width
     * @param integer $height
     *
     * @throws AnsiException
     * @return void
     */
    protected function detectAndSetSize($width, $height)
    {
        if (true !== empty($width)) {
            $this->setWidth($width);
        } else {
            $this->detectWidth();
        }

        if (true !== empty($height)) {
            $this->setHeight($height);
        } else {
            $this->detectHeight();
        }
    }
}