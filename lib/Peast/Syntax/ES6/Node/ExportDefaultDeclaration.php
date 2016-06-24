<?php
namespace Peast\Syntax\ES6\Node;

class ExportDefaultDeclaration extends Node implements ModuleDeclaration
{
    protected $declaration;
    
    public function getDeclaration()
    {
        return $this->declaration;
    }
    
    public function setDeclaration($declaration)
    {
        $this->assertType($declaration, array("Declaration", "Expression"));
        $this->declaration = $declaration;
        return $this;
    }
}