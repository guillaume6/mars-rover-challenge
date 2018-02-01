<?php

namespace App\Src\RoverNavigation;
use InvalidArgumentException;

/**
 * @author Guillaume Blondeau <guillaume6>
 * 
 * Defines the position and moves used by a Rover
 */
class Rover
{
    /**
     * X position
     * 
     * @var int 
     */
    protected $currentXPosition;
    
    /**
     * Y position
     * 
     * @var int 
     */
    protected $currentYPosition;
    
    /**
     * Current direction: N / E / S / W
     * 
     * @var int 
     */
    protected $currentDirection;   
    
    /**
     * List of moving instructions
     * 
     * @var array 
     */
    protected $movingInstructions;


    /**
     * Initialise the position of a rover
     * 
     * @param int $x
     * @param int $y
     * @param string $direction
     * @param Platform $platform
     * @throws InvalidArgumentException
     */
    public function setRoverPosition(int $x, int $y, string $direction, Platform $platform)
    {
        if ($x < $platform->getMinX() || $x > $platform->getMaxX()) {
            throw new InvalidArgumentException("Invalid x argument: must be between {$platform->getMinX()} and {$platform->getMaxX()}");
        }
        
        if ($y < $platform->getMinY() || $x > $platform->getMaxY()) {
            throw new InvalidArgumentException("Invalid y argument: must be between {$platform->getMinY()} and {$platform->getMaxY()}");
        }

        if (!in_array($direction, CARDINAL_POINTS)) {
            throw new InvalidArgumentException("Invalid argument 'direction': must be one of the following" . implode(',', CARDINAL_POINTS));
        }
        
        $this->currentXPosition = $x;
        $this->currentYPosition = $y;
        $this->currentDirection = $direction;   
    }
    
    /**
     * Set the moving instructions for the current rover
     * 
     * @param type $movingInstructions
     * @throws InvalidArgumentException
     */
    public function setMovingInstructions(string $movingInstructions)
    {
        $return = preg_match('/^[LRM]+$/', $movingInstructions);
        if ($return === 0 || $return === FALSE) {
            throw new InvalidArgumentException("Invalid argument 'movingInstructions': must be a string containing one of these L, M, R");
        }
        
        $this->movingInstructions = str_split($movingInstructions);
    }
    
    /**
     * Rover navigation
     * 
     * @param type $platform
     */
    public function navigate(Platform $platform)
    {
        foreach ($this->movingInstructions as $move) {
            $this->changePosition($move, $platform);
        }
    }

    public function getCurrentPosition() {
        return [
            $this->currentXPosition,
            $this->currentYPosition,
            $this->currentDirection,
        ];
    }

    /**
     * Change the position of a rover
     * 
     * @param string $move
     * @param \App\Src\RoverNavigation\Platform $platform
     * @throws InvalidArgumentException
     */
    protected function changePosition(string $move, Platform $platform)
    {
        switch ($move)
        {
            case Platform::MOVE_LEFT:
                $this->setNewDirection(-1);
                break;
            case Platform::MOVE_RIGHT:
                $this->setNewDirection(1);
                break;
            case Platform::MOVE_FORWARD:
                $this->move($platform);
                break;
            default:
                throw new InvalidArgumentException("Invalid argument 'direction': must be one of the following" . implode(',', $platform->getAllowedDirections()));
        }
    }
    
    /**
     * Move the rover forward
     * 
     * @param \App\Src\RoverNavigation\Platform $platform
     */
    protected function move(Platform $platform)
    {
        switch ($this->currentDirection) {
            case 'N':
                $this->currentYPosition = min( ($this->currentYPosition + 1), $platform->getMaxY());
                break;
            case 'E':
                $this->currentXPosition = min( ($this->currentXPosition + 1), $platform->getMaxX());
                break;
            case 'S':
                $this->currentYPosition = max( ($this->currentYPosition - 1), $platform->getMinY());
                break;
            case 'W':
                $this->currentXPosition = max( ($this->currentXPosition - 1), $platform->getMinX());
                break;
        }
    }

    /**
     * Set the new direction of a Rover to one the cardinal points
     * 
     * @param int $direction
     */
    protected function setNewDirection(int $direction)
    {
        $currentDirectionIndex = array_search($this->currentDirection, CARDINAL_POINTS);
        $nextPosition = intval($currentDirectionIndex) + $direction;
        
        $lastElementIndex = count(CARDINAL_POINTS)-1;
        if ($nextPosition < 0) {
            $this->currentDirection = CARDINAL_POINTS[$lastElementIndex];
            
        } else if ($nextPosition > $lastElementIndex) {
            $this->currentDirection = CARDINAL_POINTS[0];
            
        } else {
            $this->currentDirection = CARDINAL_POINTS[$nextPosition];
        }
    }
    
}
