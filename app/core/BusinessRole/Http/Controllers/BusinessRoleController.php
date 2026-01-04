<?php

namespace Core\BusinessRole\Http\Controllers;

use Core\BusinessRole\Application\UseCases\ShowBusinessRole;
use Core\BusinessRole\Http\Requests\ShowBusinessRoleRequest;

class BusinessRoleController
{
    function __construct()
    {
        
    }
    function show(ShowBusinessRoleRequest $request, ShowBusinessRole $useCase){
        $entity = $useCase->handle($request->all());
        return response()->json(['message' => $entity]); 
    }
}