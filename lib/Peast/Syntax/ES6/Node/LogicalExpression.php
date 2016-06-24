<?php
namespace Peast\Syntax\ES6\Node;

class LogicalExpression extends Node implements Expression
{
    protected $operator;
    
    protected $left;
    
    protected $right;
    
    public function getOperator()
    {
        return $this->operator;
    }
    
    public function setOperator($operator)
    {
        $this->operator = $operator;
        return $this;
    }
    
    public function getLeft()
    {
        return $this->left;
    }
    
    public function setLeft(Expression $left)
    {
        $this->left = $left;
        return $this;
    }
    
    public function getRight()
    {
        return $this->right;
    }
    
    public function setRight(Expression $right)
    {
        $this->right = $right;
        return $this;
    }
}