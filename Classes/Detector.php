<?php namespace JBR\AnsiHelper;

use JBR\AnsiHelper\Detectors\UnixXterm;
use JBR\AnsiHelper\Detectors\WindowsCommander;
use JBR\AnsiHelper\Detectors\WindowsPowershell;
use JBR\AnsiHelper\Interfaces\DetectorInterface;
use JBR\AnsiHelper\Interfaces\ScreenInterface;

/**
 *
 */
class Detector
{

    /**
     * @var Detector
     */
    protected static $instance;

    /**
     * @var DetectorInterface
     */
    protected $detector = null;

    /**
     * @var ScreenInterface
     */
    protected $screen;

    /**
     * @var array
     */
    protected static $detectors = [
        UnixXterm::class,
        WindowsCommander::class,
        WindowsPowershell::class
    ];

    /**
     * Singleton
     */
    private function __construct(ScreenInterface $screen)
    {
        $this->screen = $screen;
        $this->findDetectorMatch();
    }

    /**
     * @return void
     */
    protected function findDetectorMatch()
    {
        foreach (static::$detectors as $detector) {
            /** @var DetectorInterface $detector */
            $detector = new $detector();

            if (true === $detector->match()) {
                $this->detector = $detector;
                break;
            }
        }

        if (null === $this->detector) {
            throw new AnsiException('Cannot find any defined detector!');
        }
    }

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
        $cursor = $this->screen->getCursor();

        if (null !== $column) {
            $cursor->setColumn($this->detector->setColumn($column));
        } else {
            $cursor->setColumn($this->detector->detectColumn());
        }

        if (null !== $row) {
            $cursor->setRow($this->detector->setRow($row));
        } else {
            $cursor->setRow($this->detector->detectRow());
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
            $this->screen->setWidth($this->detector->setWidth($width));
        } else {
            $this->screen->setWidth($this->detector->detectWidth());
        }

        if (true !== empty($height)) {
            $this->screen->setHeight($this->detector->setHeight($height));
        } else {
            $this->screen->setHeight($this->detector->detectHeight());
        }
    }

    /**
     * @param string $className
     *
     * @return void
     */
    public static function addDetector($className)
    {
       static::$detectors[] = $className;
    }

    /**
     * @param ScreenInterface $screen
     *
     * @return Detector
     */
    public static function get(ScreenInterface $screen)
    {
        return (static::$instance)?:static::$instance = new self($screen);
    }
}