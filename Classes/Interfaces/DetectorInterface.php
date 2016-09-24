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
     * @return boolean
     */
    public function match();

    /**
     * @return integer
     */
    public function detectColumn();

    /**
     * @return integer
     */
    public function detectRow();

    /**
     * @return integer
     */
    public function detectWidth();

    /**
     * @return integer
     */
    public function detectHeight();

    /**
     * @param integer $column
     *
     * @return integer
     */
    public function setColumn($column);

    /**
     * @param integer $row
     *
     * @return integer
     */
    public function setRow($row);

    /**
     * @param integer $width
     *
     * @return integer
     */
    public function setWidth($width);

    /**
     * @param integer $height
     *
     * @return integer
     */
    public function setHeight($height);
}