<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct(public Country $country) {}

    public function index()
    {
        $searchColumns = ['id', 'name', 'status'];
        $search = request()->search;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->country->query();

        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        // sorting
        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $countries = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());
        return view('admin.countries.index', compact('countries'));
    }
    public function create()
    {
        return view('admin.countries.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required',
        ]);

        $this->country->create($request->all());
        return redirect()->route('admin.countries.index')->with('success', 'Country created successfully.');
    }
    public function edit($id)
    {
        $country = $this->country->findOrFail($id);
        return view('admin.countries.edit', compact('country'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required',
        ]);

        $country = $this->country->findOrFail($id);
        $country->update($request->all());
        return redirect()->route('admin.countries.index')->with('success', 'Country updated successfully.');
    }
    public function stausChng(Request $request)
    {
        $country = $this->country->findOrFail($request->id);
        $country->status = !$country->status;
        $country->save();
        return ['status' => 'success'];
    }
}
