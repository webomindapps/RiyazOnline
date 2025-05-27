<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailTemplateRequest;
use App\Models\EmailTemplate;

class EmailTemplateController extends Controller
{
    public function __construct(public EmailTemplate $template) {}

    public function index()
    {
        $searchColumns = ['id', 'title', 'content', 'priority'];
        $search = request()->search;
        $order = request()->orderedColumn;
        $orderBy = request()->orderBy;
        $paginate = request()->paginate;

        $query = $this->template->query();

        if ($search != '')
            $query->where(function ($q) use ($search, $searchColumns) {
                foreach ($searchColumns as $key => $value) ($key == 0) ? $q->where($value, 'LIKE', '%' . $search . '%') : $q->orWhere($value, 'LIKE', '%' . $search . '%');
            });

        // sorting
        ($order == '') ? $query->orderByDesc('id') : $query->orderBy($order, $orderBy);

        $templates = $paginate ? $query->paginate($paginate)->appends(request()->query()) : $query->paginate(10)->appends(request()->query());
        return view('admin.templates.index', compact('templates'));
    }
    public function create()
    {
        return view('admin.templates.create');
    }
    public function store(EmailTemplateRequest $request)
    {
        $data = $request->validated();
        $this->template->create($data);
        return redirect()->route('admin.templates.index')->with('success', 'Template created successfully.');
    }
    public function edit($id)
    {
        $template = $this->template->findOrFail($id);
        return view('admin.templates.edit', compact('template'));
    }
    public function update(EmailTemplateRequest $request, $id)
    {
        $data = $request->validated();
        $template = $this->template->findOrFail($id);
        $template->update($data);
        return redirect()->route('admin.templates.index')->with('success', 'Template updated successfully.');
    }
}
