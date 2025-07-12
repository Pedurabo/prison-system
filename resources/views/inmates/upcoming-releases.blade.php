@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Upcoming Releases</h3>
                    <div>
                        <a href="{{ route('inmates.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Inmates
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($upcomingReleases->count() > 0)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Report:</strong> {{ $upcomingReleases->count() }} inmate(s) scheduled for release in the next 30 days.
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Inmate #</th>
                                        <th>Name</th>
                                        <th>Security Level</th>
                                        <th>Block</th>
                                        <th>Admission Date</th>
                                        <th>Release Date</th>
                                        <th>Days Until Release</th>
                                        <th>Crime Category</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($upcomingReleases as $inmate)
                                        <tr class="{{ $inmate->release_date->diffInDays(now()) <= 7 ? 'table-warning' : '' }}">
                                            <td>{{ $inmate->inmate_number }}</td>
                                            <td>
                                                <a href="{{ route('inmates.show', $inmate) }}">
                                                    {{ $inmate->first_name }} {{ $inmate->last_name }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $inmate->security_level === 'maximum' ? 'danger' : ($inmate->security_level === 'medium' ? 'warning' : 'info') }}">
                                                    {{ ucfirst($inmate->security_level) }}
                                                </span>
                                            </td>
                                            <td>{{ $inmate->block }}</td>
                                            <td>{{ $inmate->admission_date->format('M d, Y') }}</td>
                                            <td>
                                                <strong>{{ $inmate->release_date->format('M d, Y') }}</strong>
                                            </td>
                                            <td>
                                                @php
                                                    $daysUntilRelease = $inmate->release_date->diffInDays(now());
                                                @endphp
                                                <span class="badge badge-{{ $daysUntilRelease <= 7 ? 'danger' : ($daysUntilRelease <= 14 ? 'warning' : 'info') }}">
                                                    {{ $daysUntilRelease }} days
                                                </span>
                                            </td>
                                            <td>{{ $inmate->crime_category }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('inmates.show', $inmate) }}"
                                                       class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    <a href="{{ route('inmates.edit', $inmate) }}"
                                                       class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    @if($daysUntilRelease <= 7)
                                                        <button class="btn btn-sm btn-success" disabled>
                                                            <i class="fas fa-exclamation-triangle"></i> Urgent
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5>Release Summary</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="text-center">
                                                    <h4 class="text-danger">{{ $upcomingReleases->where('release_date', '<=', now()->addDays(7))->count() }}</h4>
                                                    <small class="text-muted">This Week</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-center">
                                                    <h4 class="text-warning">{{ $upcomingReleases->where('release_date', '>', now()->addDays(7))->where('release_date', '<=', now()->addDays(14))->count() }}</h4>
                                                    <small class="text-muted">Next Week</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <div class="text-center">
                                                    <h4 class="text-info">{{ $upcomingReleases->where('release_date', '>', now()->addDays(14))->where('release_date', '<=', now()->addDays(21))->count() }}</h4>
                                                    <small class="text-muted">Week 3</small>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-center">
                                                    <h4 class="text-info">{{ $upcomingReleases->where('release_date', '>', now()->addDays(21))->count() }}</h4>
                                                    <small class="text-muted">Week 4</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h5>Security Level Distribution</h5>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="text-center">
                                                    <h4 class="text-info">{{ $upcomingReleases->where('security_level', 'minimum')->count() }}</h4>
                                                    <small class="text-muted">Minimum</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="text-center">
                                                    <h4 class="text-warning">{{ $upcomingReleases->where('security_level', 'medium')->count() }}</h4>
                                                    <small class="text-muted">Medium</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="text-center">
                                                    <h4 class="text-danger">{{ $upcomingReleases->where('security_level', 'maximum')->count() }}</h4>
                                                    <small class="text-muted">Maximum</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <strong>Great!</strong> No inmates are scheduled for release in the next 30 days.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
