<?php
namespace Peast\Syntax;

abstract class Node
{
    protected $loc;
    
    public function getType()
    {
        $class = explode("\\", get_class($this));
        return array_pop($class);
    }
    
    public function getLocation()
    {
        return $this->loc;
    }
    
    public function setStartPosition(Position $position)
    {
        if (!$this->loc) {
            $this->loc = new SourceLocation;
        }
        $this->loc->setStart($position);
        return $this;
    }
    
    public function setEndPosition(Position $position)
    {
        if (!$this->loc) {
            $this->loc = new SourceLocation;
        }
        $this->loc->setEnd($position);
        return $this;
    }
    
    abstract public function compile();
    
    public function __toString()
    {
        return $this->compile();
    }
    
    protected function compileNodeList($list, $separator = "")
    {
        if (!count($list)) {
            return "";
        }
        $sources = array();
        foreach ($list as $item) {
            $sources[] = $item->compile();
        }
        return implode($separator, $sources);
    }
    
    protected function assertArrayOf($params, $classes, $allowNull = false)
    {
        if (!is_array($classes)) {
            $classes = array($classes);
        }
        if (!is_array($params)) {
            $this->typeError($params, $classes, $allowNull, true);
        } else {
            foreach ($params as $param) {
                foreach ($classes as $class) {
                    if ($param === null && $allowNull) {
                        continue 2;
                    } else {
                        $c = $this->addNamespace($class);
                        if ($param instanceof $c) {
                            continue 2;
                        }
                    }
                }
                $this->typeError($param, $classes, $allowNull, true, true);
            }
        }
    }
    
    protected function assertType($param, $classes, $allowNull = false)
    {
        if (!is_array($classes)) {
            $classes = array($classes);
        }
        if ($param === null) {
            if (!$allowNull) {
                $this->typeError($param, $classes, $allowNull);
            }
        } else {
            foreach ($classes as $class) {
                $c = $this->addNamespace($class);
                if ($param instanceof $c) {
                    return;
                }
            }
            $this->typeError($param, $classes, $allowNull);
        }
    }
    
    protected function addNamespace($class)
    {
        $parts = explode("\\", get_class($this));
        $parts[count($parts) -1] = $class;
        return implode("\\", $parts);
    }
    
    protected function typeError($var, $allowedTypes, $allowNull = false,
                                 $array = false, $inArray = false)
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $method = $backtrace[2]["class"] . "::" . $backtrace[2]["function"];
        $msg = "Argument 0 passed to $method must be ";
        if ($array) {
            $msg .= "an array of ";
        }
        $msg .= implode(" or ", $allowedTypes);
        if ($allowNull) {
            $msg .= " or null";
        }
        if (is_object($var)) {
            $parts = explode("\\", get_class($var));
            $type = array_pop($parts);
        } else {
            $type = gettype($var);
        }
        if ($inArray) {
            $type = "array of $type";
        }
        $msg .= ", $type given";
        if (version_compare(phpversion(), '7', '>=')) {
            throw new \TypeError($msg);
        } else {
            trigger_error($msg, E_USER_ERROR);
        }
    }
}