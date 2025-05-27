<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminMail;
use Illuminate\Http\Request;

class AdminMailController extends Controller
{
    public function __construct(public AdminMail $mail) {}

    public function index()
    {
        $searchColumns = ['id', 'name', 'email', 'status'];
        $search = request()->search;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->mail->query();

        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        // sorting
        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $mails = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());
        return view('admin.mails.index', compact('mails'));
    }
    public function create()
    {
        return view('admin.mails.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'status' => 'required|in:1,0',
        ]);

        $this->mail->create($request->all());
        return redirect()->route('admin.mails.index')->with('success', 'Mail created successfully.');
    }
    public function edit($id)
    {
        $mail = $this->mail->findOrFail($id);
        return view('admin.mails.edit', compact('mail'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'status' => 'required|in:active,inactive',
        ]);

        $mail = $this->mail->findOrFail($id);
        $mail->update($request->all());
        return redirect()->route('admin.mails.index')->with('success', 'Mail updated successfully.');
    }
    public function delete($id)
    {
        $mail = $this->mail->findOrFail($id);
        $mail->delete();
        return redirect()->route('admin.mails.index')->with('success', 'Mail deleted successfully.');
    }
    public function statusChng(Request $request)
    {
        $mail = $this->mail->find($request->id);
        if ($mail->status == 0) {
            $mail->status = 1;
            $mail->save();
        } else {
            $mail->status = 0;
            $mail->save();
        }
        return ['status' => 'success'];
    }
}
