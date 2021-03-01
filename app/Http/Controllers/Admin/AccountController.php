<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\User;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

class AccountController extends Controller
{
    public function admin_index_account()
    {
        $account = User::where('id', '!=', auth()->user()->id)->role('admin')->paginate(5);
        return view('admin.account.admin.index', [
            'accounts' => $account
        ]);
    }

    public function costumer_index_account()
    {
        $account = User::where('id', '!=', auth()->user()->id)->role('customer')->paginate(5);
        return view('admin.account.customer.index', [
            'accounts' => $account
        ]);
    }
    
    public function boss_index_account()
    {
        $account = User::where('id', '!=', auth()->user()->id)->role('boss')->paginate(5);
        return view('admin.account.boss.index', [
            'accounts' => $account
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account = User::where('id', '!=', auth()->user()->id)->paginate(5);
        return view('admin.account.index', [
            'accounts' => $account
        ]);
    }

    public function index_latest()
    {
        $account = User::where('id', '!=', auth()->user()->id)->latest()->paginate(5);
        return view('admin.account.index', [
            'accounts' => $account
        ]);
    }

    public function index_ascending()
    {
        $account = User::where('id', '!=', auth()->user()->id)->orderBy('name', 'ASC')->paginate(5);
        return view('admin.account.index', [
            'accounts' => $account
        ]);
    }

    public function index_descending()
    {
        $account = User::where('id', '!=', auth()->user()->id)->orderBy('name', 'DESC')->paginate(5);
        return view('admin.account.index', [
            'accounts' => $account
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        $attr = $request->all();
        $attr['password'] = bcrypt($request->password);
        $thumb = request()->file('avatar') ? request()->file('avatar')->store("images/avatar") : null;
        $attr['avatar'] = $thumb;
        $user = User::create($attr);
        $user->assignRole(request('role'));
        Alert::success('Information Message', 'Data Saved');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $user = User::findOrFail($id);
       return view('admin.account.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $attr = $this->validate(request(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,'.$id],
            'avatar' => ['mimes:png,jpg,jpeg,svg', 'max:2048']
        ]);
        $user = User::findOrFail($id);
        if ($user->avatar == null) {
            if (request()->file('avatar')) {
                $thumbnail = request()->file('avatar')->store("images/avatar");
            } else {
                $thumbnail = null;
            }
        } else {
            if (request()->file('avatar')) {
                \Storage::delete($user->avatar);
                $thumbnail = request()->file('avatar')->store("images/avatar");
            } else {
                $thumbnail = $user->avatar;
            }
        }
        $attr['avatar'] = $thumbnail;
        $user->syncRoles(request('role'));
        $user->update($attr);
        Alert::success('Message Information', 'Data Updated');
        return redirect()->route('admin.account.register.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user->avatar)
        {
            \Storage::delete($user->avatar);
        }
        $user->delete();
        Alert::success('Information Message', 'Data Deleted');
        return back();
    }
}
