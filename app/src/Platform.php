<?php

namespace App\Src\RoverNavigation;


/**
 * @author Guillaume Blondeau <guillaume6>
 * 
 * Defines a platform used by rovers
 */
class Platform {
    
    /**
     *  Move constants used by the roves to move around the platform
     */
    const MOVE_LEFT = 'L';
    const MOVE_RIGHT = 'R';
    const MOVE_FORWARD = 'M';
    
    /**
     * List of allowed directions used within the platform
     * 
     * @var array 
     */
    protected $allowedDirections = [self::MOVE_LEFT, self::MOVE_RIGHT, self::MOVE_FORWARD]; 
    
    /**
     * Coordinates (x,y) of bottom left platform
     * 
     * @var array 
     */
    protected $bottomLeftCoordinates = [0,0];
    
    /**
     * Coordinates (x,y) of top right platform
     * 
     * @var array 
     */
    protected $topRightCoordinates = [];
    
    /**
     * Set the coordinates of the top right platform
     * 
     * @param int $x
     * @param int $y
     */
    public function setTopRightCoordinates(int $x, int $y) {               
        $this->topRightCoordinates = [$x, $y];
    }
    
    /******************************************************************
     * ****************************************************************
     * ****************** GETTERS / SETTERS ***************************
     * ****************************************************************
     * ****************************************************************
     */
    
    
    public function getMaxX()
    {
        return $this->topRightCoordinates[0];
    }
    
    public function getMinX()
    {
        return $this->bottomLeftCoordinates[1];
    }
    
    public function getMaxY()
    {
        return $this->topRightCoordinates[1];
    }
    
    public function getMinY()
    {
        return $this->bottomLeftCoordinates[1];
    }
    
    public function getAllowedDirections()
    {
        return $this->allowedDirections;
    }
    
}

