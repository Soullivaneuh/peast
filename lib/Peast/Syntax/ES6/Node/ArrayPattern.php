<?php
namespace Peast\Syntax\ES6\Node;

class ArrayPattern extends Node implements Pattern
{
    protected $elements = array();
    
    public function getElements()
    {
        return $this->elements;
    }
    
    public function setElements($elements)
    {
        $this->assertArrayOf($elements, "Pattern", true);
        $this->elements = $elements;
        return $this;
    }
    
    public function compile()
    {
        $strings = array();
        foreach ($this->getElements() as $el) {
            if ($el === null) {
                $strings[] = "";
            } else {
                $strings[] = $el->compile();
            }
        }
        
        return "[" . implode(",", $strings) . "]";
    }
}