<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('list-module',[App\Http\Controllers\ListController::class, 'listModule']);
Route::post('list-employee',[App\Http\Controllers\ListController::class, 'listEmployee']);
Route::post('list-employeeall',[App\Http\Controllers\ListController::class, 'listEmployeeAll']);
Route::post('list-employeead',[App\Http\Controllers\ListController::class, 'listEmployeeAD']);
Route::post('list-sidemenu',[App\Http\Controllers\ListController::class, 'listSideMenu']);
Route::post('list-icon',[App\Http\Controllers\ListController::class, 'listIcon']);
Route::post('list-sequence',[App\Http\Controllers\ListController::class, 'listSequence']);
Route::post('list-company',[App\Http\Controllers\ListController::class, 'listCompany']);
Route::post('list-companycode',[App\Http\Controllers\ListController::class, 'listCompanyCode']);
Route::post('list-department',[App\Http\Controllers\ListController::class, 'listDepartment']);
Route::post('list-location',[App\Http\Controllers\ListController::class, 'listLocation']);
Route::post('list-designation',[App\Http\Controllers\ListController::class, 'listDesignation']);
Route::post('list-grade',[App\Http\Controllers\ListController::class, 'listGrade']);
Route::post('list-level',[App\Http\Controllers\ListController::class, 'listLevel']);
Route::post('list-ethnic',[App\Http\Controllers\ListController::class, 'listEthnic']);
Route::post('list-religion',[App\Http\Controllers\ListController::class, 'listReligion']);
Route::post('list-nationality',[App\Http\Controllers\ListController::class, 'listNationality']);
Route::post('list-user',[App\Http\Controllers\ListController::class, 'listUser']);
Route::post('list-code',[App\Http\Controllers\ListController::class, 'listCode']);
Route::post('list-approvaltype',[App\Http\Controllers\ListController::class, 'listApprovaltype']);
Route::post('list-developer',[App\Http\Controllers\ListController::class, 'listDeveloper']);
Route::post('list-approver/{modulename}',[App\Http\Controllers\ListController::class, 'listApprover']);
Route::post('list-project',[App\Http\Controllers\ListController::class, 'listProject']);
Route::post('list-parentproject',[App\Http\Controllers\ListController::class, 'listParentProject']);
Route::post('list-categoryform/{modulename}',[App\Http\Controllers\ListController::class, 'listCategoryFormWithModule']);
Route::post('list-categoryform',[App\Http\Controllers\ListController::class, 'listCategoryForm']);
Route::post('list-uavasset',[App\Http\Controllers\ListController::class, 'listUavAsset']);
Route::post('list-categoryhrsc',[App\Http\Controllers\ListController::class, 'listCategoryHrsc']);
Route::post('list-unit',[App\Http\Controllers\ListController::class, 'listUnit']);
Route::post('list-currency',[App\Http\Controllers\ListController::class, 'listCurrency']);
Route::post('list-buyer',[App\Http\Controllers\ListController::class, 'listBuyer']);
Route::post('list-ecatalog',[App\Http\Controllers\ListController::class, 'listEcatalog']);
Route::post('list-pg',[App\Http\Controllers\ListController::class, 'listPurchasinguser']);
