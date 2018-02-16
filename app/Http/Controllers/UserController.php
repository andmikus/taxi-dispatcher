<?php namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Entities\User;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UserFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     *  Display users list
     *
     * @param UsersDataTable $dataTable
     *
     * @return mixed
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserFormRequest $request
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(UserFormRequest $request)
    {
        try {

            DB::beginTransaction();

            $request->merge(['password' => bcrypt($request->password)]);
            if ($user = User::create($request->all())) {

                $profile = $user->profile()->create($request->only('type'));
            }

            DB::commit();

        } catch (\Exception $e) {

            logger()->error($e->getMessage());

            return redirect()->back()->withInput();
        }

        return redirect()->route('user.index');
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     *  Update given User
     *
     * @param UserFormRequest $request
     * @param User $user
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(UserFormRequest $request, User $user)
    {
        try {

            DB::beginTransaction();

            $request->merge(['password' => bcrypt($request->password)]);

            if ($user->update($request->all())) {

                $user->profile()->update($request->only('type'));
            }

            DB::commit();

        } catch (\Exception $e) {

            logger()->error($e->getMessage());

            return redirect()->back()->withInput();
        }

        return redirect()->route('user.index');
    }
}
