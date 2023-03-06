<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:show-permissions')->only(['index']);
        $this->middleware('can:create-permission')->only(['create', 'store']);
        $this->middleware('can:edit-permission')->only(['edit', 'update']);
        $this->middleware('can:delete-permission')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $permissions = Permission::query();

        if ($keyword = request('search')) {
            $permissions->where('name', 'LIKE', "%{$keyword}%")
                ->orWhere('label', 'LIKE', "%{$keyword}%");
        }

        $permissions = $permissions->latest()->paginate(20);
        return view('admin.permissions.all', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions'],
            'label' => ['required', 'string', 'max:255'],
        ]);

        Permission::create($data);

        alert()->success('مطلب مورد نظر شما با موفقیت ایجاد شد');

        return redirect(route('admin.permissions.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Permission $permission
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Permission $permission
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions')->ignore($permission->id)],
            'label' => ['required', 'string', 'max:255'],
        ]);
        $permission->update($data);

        if ($request->has('verify')) {
            $permission->markEmailAsVerified();
        }

        alert()->success('مطلب مورد نظر شما با موفقیت ویرایش شد');
        return redirect(route('admin.permissions.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Permission $permission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        alert()->success('مطلب مورد نظر شما با موفقیت حذف شد');
        return back();
    }
}
