<?php
/**
 * Created by PhpStorm.
 * User: jennes
 * Date: 29.09.2016
 * Time: 21:39
 */

namespace JBR\AnsiHelper\Interfaces;


interface DetectorInterface
{
    const RETURN_OKAY = 0;

    /**
     * @return void
     */
    public function detectColumn();

    /**
     * @return void
     */
    public function detectRow();

    /**
     * @return void
     */
    public function detectWidth();

    /**
     * @return void
     */
    public function detectHeight();

    /**
     * @param integer $column
     *
     * @return void
     */
    public function setColumn($column);

    /**
     * @param integer $row
     *
     * @return void
     */
    public function setRow($row);

    /**
     * @param integer $width
     *
     * @return void
     */
    public function setWidth($width);

    /**
     * @param integer $height
     *
     * @return void
     */
    public function setHeight($height);
}