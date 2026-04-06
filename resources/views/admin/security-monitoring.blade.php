@extends('layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .stat-box {
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-box.danger {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .stat-box.warning {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .stat-box.success {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stat-box h3 {
            margin: 0;
            font-size: 2.5em;
            font-weight: bold;
        }

        .stat-box p {
            margin: 10px 0 0 0;
            font-size: 0.9em;
            opacity: 0.9;
        }

        .activity-item {
            padding: 12px 15px;
            border-left: 4px solid #667eea;
            margin-bottom: 10px;
            background: #f8f9fa;
            border-radius: 4px;
        }

        .activity-item.danger {
            border-left-color: #f5576c;
        }

        .activity-item.warning {
            border-left-color: #ffc107;
        }

        .activity-item.success {
            border-left-color: #4caf50;
        }

        .activity-type-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: bold;
            margin-right: 10px;
        }

        .activity-type-badge.locked {
            background: #f5576c;
            color: white;
        }

        .activity-type-badge.alert {
            background: #ffc107;
            color: #333;
        }

        .activity-type-badge.success {
            background: #4caf50;
            color: white;
        }

        .ip-table {
            font-size: 0.9em;
        }

        .locked-account-badge {
            background: #f5576c;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.8em;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <h1 class="mb-4">
            <i class="fa fa-shield-alt"></i> Security Monitoring Dashboard
        </h1>

        <!-- Statistics Row -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stat-box success">
                    <h3>{{ $stats['total_suspicious_activities'] ?? 0 }}</h3>
                    <p>Total Suspicious Activities</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-box warning">
                    <h3>{{ $stats['activities_today'] ?? 0 }}</h3>
                    <p>Activities Today</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-box danger">
                    <h3>{{ $stats['locked_accounts'] ?? 0 }}</h3>
                    <p>Currently Locked Accounts</p>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-box">
                    <h3>{{ $stats['failed_attempts_today'] ?? 0 }}</h3>
                    <p>Failed Login Attempts Today</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Recent Suspicious Activities -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fa fa-exclamation-triangle"></i> Recent Suspicious Activities
                        </h5>
                    </div>
                    <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                        @forelse($suspiciousActivities as $activity)
                            <div
                                class="activity-item {{ $activity->activity_type === 'account_locked' ? 'danger' : 'warning' }}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div style="flex: 1;">
                                        <span
                                            class="activity-type-badge {{ $activity->activity_type === 'account_locked' ? 'locked' : 'alert' }}">
                                            {{ strtoupper($activity->activity_type) }}
                                        </span>
                                        <br>
                                        <strong>{{ $activity->username_or_email ?? 'N/A' }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            <i class="fa fa-globe"></i> {{ $activity->ip_address }}
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted d-block">
                                            {{ $activity->created_at->diffForHumans() }}
                                        </small>
                                        @if($activity->alert_sent)
                                            <small class="text-success">
                                                <i class="fa fa-check"></i> Alert Sent
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                @if($activity->details)
                                    <small class="text-muted d-block mt-2">
                                        Details: {{ $activity->details }}
                                    </small>
                                @endif
                            </div>
                        @empty
                            <p class="text-muted text-center py-5">
                                <i class="fa fa-check-circle"></i> No suspicious activities detected
                            </p>
                        @endforelse
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('security.export') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa fa-download"></i> Export to CSV
                        </a>
                    </div>
                </div>
            </div>

            <!-- Locked Accounts -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fa fa-lock"></i> Locked Accounts ({{ count($lockedAccounts) }})
                        </h5>
                    </div>
                    <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                        @forelse($lockedAccounts as $account)
                            <div class="mb-3 p-3"
                                style="background: #f8f9fa; border-radius: 4px; border-left: 3px solid #f5576c;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div style="flex: 1;">
                                        <strong>{{ $account->username }}</strong><br>
                                        <small class="text-muted">{{ $account->email }}</small><br>
                                        <small class="text-danger">
                                            <i class="fa fa-clock"></i>
                                            Unlock in {{ $account->locked_until->diffForHumans() }}
                                        </small>
                                    </div>
                                    <button class="btn btn-sm btn-warning" onclick="unlockAccount({{ $account->id }})">
                                        <i class="fa fa-unlock"></i> Unlock
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    Failed Attempts: {{ $account->login_attempts }}
                                </small>
                            </div>
                        @empty
                            <p class="text-muted text-center py-5">
                                <i class="fa fa-check-circle"></i> No locked accounts
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Failed Login Attempts by IP -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fa fa-network-wired"></i> Failed Login Attempts by IP
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-hover ip-table">
                    <thead class="table-light">
                        <tr>
                            <th>IP Address</th>
                            <th>Failed Attempts (15m)</th>
                            <th>Last Attempt</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentFailedLogins as $ip => $attempts)
                            <tr>
                                <td>
                                    <strong>{{ $ip }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-danger">{{ count($attempts) }}</span>
                                </td>
                                <td>
                                    {{ $attempts->first()->attempted_at->format('Y-m-d H:i:s') }}
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-danger" onclick="blockIp('{{ $ip }}')">
                                        <i class="fa fa-ban"></i> Block
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    No failed attempts in recent logs
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        function unlockAccount(userId) {
            if (confirm('Apakah Anda yakin ingin membuka kunci akun ini?')) {
                $.ajax({
                    url: '{{ route('security.unlock') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: userId
                    },
                    success: function (response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload();
                        }
                    },
                    error: function (error) {
                        alert('Terjadi kesalahan: ' + error.statusText);
                    }
                });
            }
        }

        function blockIp(ipAddress) {
            if (confirm('Apakah Anda yakin ingin memblokir IP: ' + ipAddress + ' selama 7 hari?')) {
                $.ajax({
                    url: '{{ route('security.block-ip') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ip_address: ipAddress
                    },
                    success: function (response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload();
                        }
                    },
                    error: function (error) {
                        alert('Terjadi kesalahan: ' + error.statusText);
                    }
                });
            }
        }

        // Auto refresh every 30 seconds
        setInterval(function () {
            location.reload();
        }, 30000);
    </script>
@endsection