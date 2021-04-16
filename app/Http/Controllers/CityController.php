<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Governorate;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = City::paginate(20);
        return view('cities.index', compact('records'));
    }

    
    public function create()
    {
        $governorates = Governorate::pluck('name', 'id')->toArray();
        return view('cities.create', compact('governorates'));
    }


    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'governorate_id' => 'required'
        ];
        $message = [
            'name.required' => 'الاسم مطلوب',
            'governorate_id.required' => 'المحافظة مطلوبة ',
        ];
        $this->validate($request, $rules, $message);
        $record = City::create($request->all());
        flash()->success('تمت إضافة المدينة بنجاح');
        return redirect(route('cities.index'));
    }


    public function edit($id)
    {
        $model = City::findOrFail($id);
        return view('cities.edit', compact('model'));
    }

    public function update(Request $request, $id)
    {
        $record = City::findOrFail($id);
            $record->update($request->all());
        flash()->success('لقـــد تـــــــم التحــديــــــــث بنــجـــــــاح');
        return redirect(route('cities.index'));
    }


    public function destroy($id)
    {
        $record = City::find($id);
        if (!$record) {
            return response()->json([
                'status'  => 0,
                'message' => 'تعذر الحصول على البيانات'
            ]);
        }

        $record->delete();
        return response()->json([
                'status'  => 1,
                'message' => 'تم الحذف بنجاح',
                'id'      => $id
            ]);
    }

}
