<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::with('department')->get();
        $departments = Department::all();
        $guards = User::where('role', 'guard')->with('department')->get();

        return view('admin.dashboard', compact('users', 'departments', 'guards'));
    }

    public function createGuard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'department_id' => 'required|exists:departments,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guard',
            'department_id' => $request->department_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Guard created successfully',
            'user' => $user->load('department')
        ]);
    }

    public function updateGuard(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'department_id' => 'required|exists:departments,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'department_id' => $request->department_id,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Guard updated successfully',
            'user' => $user->load('department')
        ]);
    }

    public function deleteGuard(User $user)
    {
        if ($user->role !== 'guard') {
            return response()->json([
                'success' => false,
                'message' => 'User is not a guard'
            ], 400);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Guard deleted successfully'
        ]);
    }

    public function guardDashboard()
    {
        $guards = User::where('role', 'guard')->with('department')->get();
        $departments = Department::all();

        // Get shift statistics
        $totalGuards = $guards->count();
        $activeGuards = $guards->where('is_active', true)->count();
        $departmentsWithGuards = $guards->groupBy('department_id')->count();

        return view('admin.guard-dashboard', compact('guards', 'departments', 'totalGuards', 'activeGuards', 'departmentsWithGuards'));
    }

    public function shiftMonitoring()
    {
        $guards = User::where('role', 'guard')->with('department')->get();

        // Simulate shift data (in a real system, this would come from a shifts table)
        $shifts = [
            'morning' => $guards->take(3),
            'afternoon' => $guards->take(2),
            'night' => $guards->take(1),
        ];

        return view('admin.shift-monitoring', compact('guards', 'shifts'));
    }

    public function toggleGuardStatus(User $user)
    {
        if ($user->role !== 'guard') {
            return response()->json([
                'success' => false,
                'message' => 'User is not a guard'
            ], 400);
        }

        $user->update(['is_active' => !$user->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Guard status updated successfully',
            'is_active' => $user->is_active
        ]);
    }

    public function editGuard(User $user)
    {
        if ($user->role !== 'guard') {
            return response()->json([
                'success' => false,
                'message' => 'User is not a guard'
            ], 400);
        }

        return response()->json($user->load('department'));
    }
}
