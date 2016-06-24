<?php
namespace Peast\Syntax\ES6\Node;

class ExpressionStatement extends Node implements Statement
{
    protected $expression;
    
    public function getExpression()
    {
        return $this->expression;
    }
    
    public function setExpression(Expression $expression)
    {
        $this->expression = $expression;
        return $this;
    }
}