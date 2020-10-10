<?php

namespace App\Http\Controllers;

use App\Models\UserCategory;
use Exception;
use Illuminate\Http\Request;

class UserCategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required|unique:user_categories|min:3',
           'ram_limit' => 'required|numeric|min:50',
           'storage_limit' => 'required|numeric|min:200',
        ]);
        UserCategory::create($request->all());
        
        return redirect()->route('settings.index')->with('success', 'Category has been saved!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'ram_limit' => 'required|numeric|min:50',
            'storage_limit' => 'required|numeric|min:200',
         ]);

        $category = UserCategory::firstWhere('id', $id);
        $category->update($request->all());

        return redirect()->route('settings.index')->with('success', 'Category has been updated!');
    }

    public function destroy($id)
    {
        try{
            $category = UserCategory::firstWhere('id', $id);
            $category->delete();

            return redirect()->route('settings.index')->with('success', 'Category has been deleted!');
        } catch(Exception $e) {
            return redirect()->route('settings.index')->with('error', $e->getMessage());
        }
    }
}
