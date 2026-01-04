<?php

namespace Core\BusinessRole\Http\Controllers;

use Core\BusinessRole\Application\UseCases\ViewBusinessRole;
use Illuminate\Http\Request;

class ViewBusinessRoleController
{
    function __construct()
    {
        
    }
    function index(Request $request, ViewBusinessRole $useCase){
        $entity = $useCase->handle($request->all());
        return response()->json(['message' => $entity]); 
    }
}