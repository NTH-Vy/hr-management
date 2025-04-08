<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;

class EmployeeController extends Controller
{
    public function dashboard()
    {
        $user = session('user');
        
        // Today's attendance
        $todayAttendance = Attendance::where('user_id', $user->id)
                                    ->whereDate('date', today())
                                    ->first();
        
        // Monthly summary
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        
        $monthlySummary = [
            'present' => Attendance::where('user_id', $user->id)
                                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                                ->where('status', 'present')
                                ->count(),
            'late' => Attendance::where('user_id', $user->id)
                            ->whereBetween('date', [$startOfMonth, $endOfMonth])
                            ->where('status', 'late')
                            ->count(),
            'absent' => Attendance::where('user_id', $user->id)
                                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                                ->where('status', 'absent')
                                ->count(),
            'half_day' => Attendance::where('user_id', $user->id)
                                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                                ->where('status', 'half_day')
                                ->count(),
        ];
        
        return view('employee.dashboard', compact('todayAttendance', 'monthlySummary'));
    }

    public function editProfile()
    {
        $user = User::find(session('user')->id);
        return view('employee.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(session('user')->id);

        $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|different:current_password',
            'confirm_password' => 'nullable|same:new_password'
        ]);

        // Update basic info
        $user->full_name = $request->full_name;
        $user->email = $request->email;

        // Update password if provided
        if ($request->new_password) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Current password is incorrect');
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();
        
        // Update session data
        session(['user' => $user]);

        return redirect('/employee/dashboard')->with('success', 'Profile updated successfully');
    }

    public function checkIn(Request $request)
    {
        $attendance = new Attendance();
        $attendance->user_id = auth()->id();
        $attendance->date = now()->toDateString();
        $attendance->check_in = now(); // Lưu giờ hiện tại
        $attendance->status = 'present'; // Hoặc logic khác nếu cần
        $attendance->save();

        return redirect()->back()->with('success', 'Checked in successfully!');
    }

    public function checkOut()
    {
        $user = session('user');
        
        // Get today's attendance
        $attendance = Attendance::where('user_id', $user->id)
                            ->whereDate('date', today())
                            ->first();
        
        if (!$attendance) {
            return redirect('/employee/dashboard')->with('error', 'You need to check in first');
        }
        
        if ($attendance->check_out) {
            return redirect('/employee/dashboard')->with('error', 'You have already checked out today');
        }
        
        $checkOutTime = now();
        
        // Calculate total working hours
        $totalHours = $checkOutTime->diffInHours($attendance->check_in);
        
        // Update status if half day (less than 4 hours)
        if ($totalHours < 4) {
            $attendance->status = 'half_day';
        }
        
        $attendance->update([
            'check_out' => $checkOutTime,
            'total_hours' => $totalHours,
            'status' => $attendance->status
        ]);
        
        return redirect('/employee/dashboard')->with('success', 'Checked out successfully at ' . $checkOutTime->format('H:i:s'));
    }

    public function attendanceHistory(Request $request)
    {
        $user = session('user');
        
        $query = Attendance::where('user_id', $user->id)
                        ->orderBy('date', 'desc');
        
        // Apply filters
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('date', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('date', '<=', $request->end_date);
        }
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $attendances = $query->paginate(15);
        
        return view('employee.attendance_history', compact('attendances'));
    }
}