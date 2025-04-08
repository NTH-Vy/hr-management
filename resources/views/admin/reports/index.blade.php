@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Báo cáo hệ thống</h1>
    <div>
        <a href="#" class="btn" style="background-color: #bf9de3ff; color: #070917ff;" data-bs-toggle="modal" data-bs-target="#filterModal">
            <i class="fas fa-filter"></i> Lọc báo cáo
        </a>
        <a href="{{ route('admin.reports.export') }}" class="btn btn-primary">
            <i class="fas fa-file-export"></i> Xuất báo cáo
        </a>
    </div>
</div>

<!-- Thống kê tổng quan -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white mb-3" style="background-color: #070917ff;">
            <div class="card-body text-center">
                <h5 class="card-title">Tổng nhân viên</h5>
                <h2 class="mb-0">{{ $totalEmployees }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white mb-3" style="background-color: #28a745;">
            <div class="card-body text-center">
                <h5 class="card-title">Nhân viên active</h5>
                <h2 class="mb-0">{{ $activeEmployees }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white mb-3" style="background-color: #17a2b8;">
            <div class="card-body text-center">
                <h5 class="card-title">Vị trí công việc</h5>
                <h2 class="mb-0">{{ $totalPositions }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white mb-3" style="background-color: #6f42c1;">
            <div class="card-body text-center">
                <h5 class="card-title">Tổng lương tháng</h5>
                <h2 class="mb-0">{{ number_format($totalSalaries, 2) }} VNĐ</h2>
            </div>
        </div>
    </div>
</div>

<!-- Biểu đồ báo cáo -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header" style="background-color: #070917ff; color: white;">
                <h3 class="mb-0">Thống kê chấm công</h3>
            </div>
            <div class="card-body">
                <canvas id="attendanceChart" height="150"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header" style="background-color: #070917ff; color: white;">
                <h3 class="mb-0">Phân bổ lương theo vị trí</h3>
            </div>
            <div class="card-body">
                <canvas id="salaryChart" height="150"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Hoạt động gần đây -->
<div class="card mb-4">
    <div class="card-header" style="background-color: #070917ff; color: white;">
        <h3 class="mb-0">Hoạt động gần đây</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Thời gian</th>
                        <th>Nhân viên</th>
                        <th>Loại</th>
                        <th>Mô tả</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentActivities as $activity)
                    <tr>
                        <td>{{ $activity->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $activity->user->full_name }}</td>
                        <td>
                            @switch($activity->type)
                                @case('attendance')
                                    <span class="badge bg-info">Chấm công</span>
                                    @break
                                @case('salary')
                                    <span class="badge bg-success">Lương</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ $activity->type }}</span>
                            @endswitch
                        </td>
                        <td>{{ Str::limit($activity->description, 50) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Không có hoạt động nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal lọc báo cáo -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #070917ff; color: white;">
                <h5 class="modal-title" id="filterModalLabel">Lọc báo cáo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="GET" action="{{ route('admin.reports.index') }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="period" class="form-label">Chu kỳ báo cáo</label>
                        <select class="form-select" id="period" name="period">
                            <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Hàng ngày</option>
                            <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Hàng tuần</option>
                            <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Hàng tháng</option>
                            <option value="quarterly" {{ $period == 'quarterly' ? 'selected' : '' }}>Hàng quý</option>
                            <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Hàng năm</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Từ ngày</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" 
                               value="{{ $startDate }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Đến ngày</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" 
                               value="{{ $endDate }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn" style="background-color: #bf9de3ff; color: #070917ff;">Áp dụng</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Biểu đồ chấm công
    const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    new Chart(attendanceCtx, {
        type: 'bar',
        data: {
            labels: @json($attendanceData['labels']),
            datasets: [
                {
                    label: 'Có mặt',
                    data: @json($attendanceData['present']),
                    backgroundColor: 'rgba(40, 167, 69, 0.7)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Vắng mặt',
                    data: @json($attendanceData['absent']),
                    backgroundColor: 'rgba(220, 53, 69, 0.7)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Đi muộn',
                    data: @json($attendanceData['late']),
                    backgroundColor: 'rgba(255, 193, 7, 0.7)',
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Số lượng'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Thời gian'
                    }
                }
            }
        }
    });

    // Biểu đồ phân bổ lương
    const salaryCtx = document.getElementById('salaryChart').getContext('2d');
    new Chart(salaryCtx, {
        type: 'doughnut',
        data: {
            labels: @json($salaryData['labels']),
            datasets: [{
                data: @json($salaryData['values']),
                backgroundColor: @json($salaryData['colors']),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.raw || 0;
                            return `${label}: ${value.toLocaleString()} VNĐ`;
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
@endsection