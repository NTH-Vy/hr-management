<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use App\Models\Activity;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Position;
use App\Models\Attendance;
use App\Models\Salary;
use App\Models\RewardsDiscipline;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // User Management
    public function users()
    {
        $users = User::with('position')->get();
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        $positions = Position::all();
        return view('admin.users.create', compact('positions'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required',
            'full_name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required',
            'position_id' => 'nullable|exists:positions,id'
        ]);

        $user = new User();
        $user->fill($request->all());
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect('/admin/users')->with('success', 'User created successfully');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $positions = Position::all();
        return view('admin.users.edit', compact('user', 'positions'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|unique:users,username,'.$id,
            'full_name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required',
            'position_id' => 'nullable|exists:positions,id'
        ]);

        $user->fill($request->except('password'));
        
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect('/admin/users')->with('success', 'User updated successfully');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('/admin/users')->with('success', 'User deleted successfully');
    }

    // Position Management
    public function positions()
    {
        $positions = Position::all();
        return view('admin.positions.index', compact('positions'));
    }

    public function createPosition()
    {
        return view('admin.positions.create');
    }

    public function storePosition(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'base_salary' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        Position::create($request->all());

        return redirect('/admin/positions')->with('success', 'Position created successfully');
    }

    public function editPosition($id)
    {
        $position = Position::findOrFail($id);
        return view('admin.positions.edit', compact('position'));
    }

    public function updatePosition(Request $request, $id)
    {
        $position = Position::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'base_salary' => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ]);

        $position->update($request->all());

        return redirect('/admin/positions')->with('success', 'Position updated successfully');
    }

    public function deletePosition($id)
    {
        $position = Position::findOrFail($id);
        
        // Check if any users are assigned to this position
        if ($position->users()->count() > 0) {
            return redirect('/admin/positions')->with('error', 'Cannot delete position because it has assigned employees');
        }

        $position->delete();
        return redirect('/admin/positions')->with('success', 'Position deleted successfully');
    }

    // Attendance Management
    public function attendances(Request $request)
    {
        $query = Attendance::with('user')->latest();
        
        // Apply filters
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        
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
        $users = User::all();
        
        return view('admin.attendances.index', compact('attendances', 'users'));
    }

    public function editAttendance($id)
    {
        $attendance = Attendance::with('user')->findOrFail($id);
        return view('admin.attendances.edit', compact('attendance'));
    }

    public function updateAttendance(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        
        $request->validate([
            'date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'status' => 'required|in:present,absent,late,half_day'
        ]);
        
        $data = $request->all();
        
        // Calculate total hours if both check in and check out are provided
        if ($request->check_in && $request->check_out) {
            $checkIn = \Carbon\Carbon::parse($request->date . ' ' . $request->check_in);
            $checkOut = \Carbon\Carbon::parse($request->date . ' ' . $request->check_out);
            $data['total_hours'] = $checkOut->diffInHours($checkIn);
        }
        
        $attendance->update($data);
        
        return redirect('/admin/attendances')->with('success', 'Attendance record updated successfully');
    }

    public function deleteAttendance($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();
        
        return redirect('/admin/attendances')->with('success', 'Attendance record deleted successfully');
    }

    public function exportAttendances(Request $request)
    {
        $query = Attendance::with('user');
        
        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->start_date) {
            $query->whereDate('date', '>=', $request->start_date);
        }
        
        if ($request->end_date) {
            $query->whereDate('date', '<=', $request->end_date);
        }
        
        $attendances = $query->get();
        
        $fileName = 'attendances_' . now()->format('Ymd_His') . '.' . $request->format;
        
        if ($request->format === 'csv') {
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ];
            
            $callback = function() use ($attendances) {
                $file = fopen('php://output', 'w');
                
                // Header row
                fputcsv($file, ['Employee', 'Date', 'Check In', 'Check Out', 'Total Hours', 'Status']);
                
                // Data rows
                foreach ($attendances as $attendance) {
                    fputcsv($file, [
                        $attendance->user->full_name,
                        $attendance->date->format('Y-m-d'),
                        $attendance->check_in ? $attendance->check_in->format('H:i:s') : '',
                        $attendance->check_out ? $attendance->check_out->format('H:i:s') : '',
                        $attendance->total_hours ?? '',
                        ucfirst(str_replace('_', ' ', $attendance->status))
                    ]);
                }
                
                fclose($file);
            };
            
            return Response::stream($callback, 200, $headers);
        }
        
        // For Excel and PDF exports, you would use Laravel Excel or a PDF library
        return back()->with('error', 'Export format not implemented yet');
    }

    // Salary Management
    public function salaries(Request $request)
    {
    $query = Salary::with('user')->latest();
    
    // Apply filters
    if ($request->has('user_id') && $request->user_id) {
        $query->where('user_id', $request->user_id);
    }
    
    if ($request->has('month') && $request->month) {
        $query->where('month', $request->month);
    }
    
    if ($request->has('status') && $request->status) {
        $query->where('status', $request->status);
    }
    
    $salaries = $query->paginate(15);
    $users = User::all();
    
    return view('admin.salaries.index', compact('salaries', 'users'));
    }

    // In app/Http/Controllers/AdminController.php

    public function createSalary()
    {
        $users = User::all();
        return view('admin.salaries.create', compact('users'));
    }

    public function storeSalary(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'month' => 'required|date_format:Y-m',
            'base_salary' => 'required|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'deduction' => 'nullable|numeric|min:0',
            'total_hours' => 'required|numeric|min:0'
        ]);

        $data = $request->all();
        $data['total_salary'] = $request->base_salary + ($request->bonus ?? 0) - ($request->deduction ?? 0);
        $data['status'] = 'pending';

        Salary::create($data);

        return redirect('/admin/salaries')->with('success', 'Salary record created successfully');
    }

    // Rewards & Disciplines Management
    public function rewardsDisciplines(Request $request)
    {
        $query = RewardsDiscipline::with(['user', 'issuedBy'])->latest();
        
        if ($request->has('type') && in_array($request->type, ['reward', 'discipline'])) {
            $query->where('type', $request->type);
        }
        
        $records = $query->paginate(15);
        $users = User::all();
        
        return view('admin.rewards_disciplines.index', compact('records', 'users'));
    }

    public function createRewardsDiscipline()
    {
        $users = User::all();
        return view('admin.rewards_disciplines.create', compact('users'));
    }

    public function storeRewardsDiscipline(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:reward,discipline',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'reason' => 'required|string|max:500'
        ]);
        
        $data = $request->all();
        $data['issued_by'] = session('user')->id;
        
        RewardsDiscipline::create($data);
        
        return redirect('/admin/rewards-disciplines')->with('success', 'Record created successfully');
    }

    public function editRewardsDiscipline($id)
    {
        $record = RewardsDiscipline::with(['user', 'issuedBy'])->findOrFail($id);
        return view('admin.rewards_disciplines.edit', compact('record'));
    }

    public function updateRewardsDiscipline(Request $request, $id)
    {
        $record = RewardsDiscipline::findOrFail($id);
        
        $request->validate([
            'type' => 'required|in:reward,discipline',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'reason' => 'required|string|max:500'
        ]);
        
        $record->update($request->all());
        
        return redirect('/admin/rewards-disciplines')->with('success', 'Record updated successfully');
    }

    public function deleteRewardsDiscipline($id)
    {
        $record = RewardsDiscipline::findOrFail($id);
        $record->delete();
        
        return redirect('/admin/rewards-disciplines')->with('success', 'Record deleted successfully');
    }

    // Payroll Management
    public function payroll(Request $request)
    {
        $query = Salary::with('user')->latest();
        
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }
        
        if ($request->has('month') && $request->month) {
            $query->where('month', $request->month);
        }
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        $payrolls = $query->paginate(15);
        $users = User::all();
        
        return view('admin.payroll.index', compact('payrolls', 'users'));
    }

    public function showPayroll($id)
    {
        $payroll = Salary::with('user')->findOrFail($id);
        
        // Get attendance summary for the payroll month
        $startDate = \Carbon\Carbon::createFromFormat('Y-m', $payroll->month)->startOfMonth();
        $endDate = \Carbon\Carbon::createFromFormat('Y-m', $payroll->month)->endOfMonth();
        
        $attendanceSummary = [
            'total_days' => $startDate->diffInDays($endDate) + 1,
            'present' => Attendance::where('user_id', $payroll->user_id)
                ->whereBetween('date', [$startDate, $endDate])
                ->where('status', 'present')
                ->count(),
            'absent' => Attendance::where('user_id', $payroll->user_id)
                ->whereBetween('date', [$startDate, $endDate])
                ->where('status', 'absent')
                ->count(),
            'late' => Attendance::where('user_id', $payroll->user_id)
                ->whereBetween('date', [$startDate, $endDate])
                ->where('status', 'late')
                ->count(),
            'half_day' => Attendance::where('user_id', $payroll->user_id)
                ->whereBetween('date', [$startDate, $endDate])
                ->where('status', 'half_day')
                ->count(),
        ];
        
        // Get rewards and disciplines for the payroll month
        $rewardsDisciplines = RewardsDiscipline::where('user_id', $payroll->user_id)
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date')
            ->get();
        
        return view('admin.payroll.show', compact('payroll', 'attendanceSummary', 'rewardsDisciplines'));
    }

    public function generatePayrollForm()
    {
        $users = User::all();
        return view('admin.payroll.generate', compact('users'));
    }

    public function generatePayroll(Request $request)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
            'user_id' => 'nullable|exists:users,id'
        ]);
        
        $month = $request->month;
        $startDate = \Carbon\Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $endDate = \Carbon\Carbon::createFromFormat('Y-m', $month)->endOfMonth();
        
        $users = $request->user_id 
            ? User::where('id', $request->user_id)->get()
            : User::all();
        
        foreach ($users as $user) {
            // Check if payroll already exists for this user and month
            $existingPayroll = Salary::where('user_id', $user->id)
                ->where('month', $month)
                ->first();
            
            if ($existingPayroll) {
                continue;
            }
            
            $baseSalary = $user->position ? $user->position->base_salary : 0;
            $bonus = 0;
            $deduction = 0;
            
            // Calculate attendance adjustments if enabled
            if ($request->include_attendance) {
                $presentDays = Attendance::where('user_id', $user->id)
                    ->whereBetween('date', [$startDate, $endDate])
                    ->where('status', 'present')
                    ->count();
                
                $totalWorkingDays = $startDate->diffInDaysFiltered(function(\Carbon\Carbon $date) {
                    return !$date->isWeekend();
                }, $endDate);
                
                if ($presentDays < $totalWorkingDays) {
                    $deduction += ($baseSalary / $totalWorkingDays) * ($totalWorkingDays - $presentDays);
                }
            }
            
            // Calculate rewards and disciplines if enabled
            if ($request->include_rewards) {
                $rewardsDisciplines = RewardsDiscipline::where('user_id', $user->id)
                    ->whereBetween('date', [$startDate, $endDate])
                    ->get();
                
                foreach ($rewardsDisciplines as $rd) {
                    if ($rd->type == 'reward') {
                        $bonus += $rd->amount;
                    } else {
                        $deduction += $rd->amount;
                    }
                }
            }
            
            // Create payroll record
            Salary::create([
                'user_id' => $user->id,
                'month' => $month,
                'base_salary' => $baseSalary,
                'bonus' => $bonus,
                'deduction' => $deduction,
                'total_hours' => 0, // You might want to calculate this based on attendance
                'total_salary' => $baseSalary + $bonus - $deduction,
                'status' => 'pending'
            ]);
        }
        
        return redirect('/admin/payroll')->with('success', 'Payroll generated successfully');
    }

    public function editPayroll($id)
    {
        $payroll = Salary::with('user')->findOrFail($id);
        return view('admin.payroll.edit', compact('payroll'));
    }

    public function updatePayroll(Request $request, $id)
    {
        $payroll = Salary::findOrFail($id);
        
        $request->validate([
            'base_salary' => 'required|numeric|min:0',
            'bonus' => 'required|numeric|min:0',
            'deduction' => 'required|numeric|min:0',
            'status' => 'required|in:pending,paid'
        ]);
        
        $data = $request->all();
        $data['total_salary'] = $request->base_salary + $request->bonus - $request->deduction;
        
        if ($request->status == 'paid' && $payroll->status != 'paid') {
            $data['payment_date'] = now();
        }
        
        $payroll->update($data);
        
        return redirect('/admin/payroll')->with('success', 'Payroll updated successfully');
    }

    public function markAsPaid($id)
    {
        $payroll = Salary::findOrFail($id);
        
        $payroll->update([
            'status' => 'paid',
            'payment_date' => now()
        ]);
        
        return redirect('/admin/payroll')->with('success', 'Payroll marked as paid');
    }

    // Reports
        public function reports(Request $request)
    {
        // Xác định khoảng thời gian báo cáo
        $period = $request->input('period', 'monthly');
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Thống kê cơ bản
        $reportData = [
            'totalEmployees' => User::count(),
            'activeEmployees' => User::count(), // Đếm tất cả user
            'totalPositions' => Position::count(),
            'totalSalaries' => Salary::whereBetween('created_at', [$startDate, $endDate])->sum('total_salary'),
            'period' => $period,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];

        // Dữ liệu chấm công (6 tháng gần nhất)
        $attendanceData = $this->getAttendanceData($period, $startDate, $endDate);

        // Dữ liệu lương theo vị trí
        $salaryData = $this->getSalaryDistributionData();

        // Hoạt động gần đây
        $recentActivities = Activity::with('user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.reports.index', array_merge($reportData, [
            'attendanceData' => $attendanceData,
            'salaryData' => $salaryData,
            'recentActivities' => $recentActivities
        ]));
    }

    private function getAttendanceData($period, $startDate, $endDate)
    {
        $data = [
            'labels' => [],
            'present' => [],
            'absent' => [],
            'late' => []
        ];

        $current = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        while ($current <= $end) {
            $label = $current->format('M Y');
            $periodStart = $current->copy();
            $periodEnd = $period === 'monthly' 
                ? $current->copy()->endOfMonth()
                : ($period === 'quarterly' 
                    ? $current->copy()->addMonths(2)->endOfMonth()
                    : $current->copy()->endOfYear());

            if ($periodEnd > $end) {
                $periodEnd = $end;
            }

            $data['labels'][] = $label;
            $data['present'][] = Attendance::whereBetween('date', [$periodStart, $periodEnd])
                ->where('status', 'present')
                ->count();
            $data['absent'][] = Attendance::whereBetween('date', [$periodStart, $periodEnd])
                ->where('status', 'absent')
                ->count();
            $data['late'][] = Attendance::whereBetween('date', [$periodStart, $periodEnd])
                ->where('status', 'late')
                ->count();

            // Di chuyển đến khoảng thời gian tiếp theo
            $current = $period === 'monthly' 
                ? $current->copy()->addMonth()
                : ($period === 'quarterly' 
                    ? $current->copy()->addMonths(3)
                    : $current->copy()->addYear());
        }

        return $data;
    }

    private function getSalaryDistributionData()
    {
        $positions = Position::with(['users' => function($query) {
            $query->withSum('salaries', 'total_salary');
        }])->get();

        $data = [
            'labels' => $positions->pluck('name')->toArray(),
            'values' => $positions->map(function($position) {
                return $position->users->sum('salaries_sum_total_salary');
            })->toArray(),
            'colors' => $positions->map(function() {
                return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            })->toArray()
        ];

        return $data;
    }
}