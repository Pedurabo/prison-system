@extends('layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Medical Record</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('medical-records.update', $medicalRecord) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inmate_id">Inmate <span class="text-danger">*</span></label>
                                    <select name="inmate_id" id="inmate_id" class="form-control @error('inmate_id') is-invalid @enderror" required>
                                        <option value="">Select Inmate</option>
                                        @foreach($inmates as $inmate)
                                            <option value="{{ $inmate->id }}"
                                                {{ old('inmate_id', $medicalRecord->inmate_id) == $inmate->id ? 'selected' : '' }}>
                                                {{ $inmate->first_name }} {{ $inmate->last_name }} (ID: {{ $inmate->id }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('inmate_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="attending_staff_id">Attending Staff <span class="text-danger">*</span></label>
                                    <select name="attending_staff_id" id="attending_staff_id" class="form-control @error('attending_staff_id') is-invalid @enderror" required>
                                        <option value="">Select Staff</option>
                                        @foreach($medicalStaff as $staff)
                                            <option value="{{ $staff->id }}"
                                                {{ old('attending_staff_id', $medicalRecord->attending_staff_id) == $staff->id ? 'selected' : '' }}>
                                                {{ $staff->first_name }} {{ $staff->last_name }} - {{ $staff->department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('attending_staff_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="visit_date">Visit Date <span class="text-danger">*</span></label>
                                    <input type="date" name="visit_date" id="visit_date"
                                           class="form-control @error('visit_date') is-invalid @enderror"
                                           value="{{ old('visit_date', $medicalRecord->visit_date->format('Y-m-d')) }}" required>
                                    @error('visit_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="emergency_contact">Emergency Contact <span class="text-danger">*</span></label>
                                    <input type="text" name="emergency_contact" id="emergency_contact"
                                           class="form-control @error('emergency_contact') is-invalid @enderror"
                                           value="{{ old('emergency_contact', $medicalRecord->emergency_contact) }}"
                                           placeholder="Emergency contact information" required>
                                    @error('emergency_contact')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="symptoms">Symptoms <span class="text-danger">*</span></label>
                            <textarea name="symptoms" id="symptoms" rows="4"
                                      class="form-control @error('symptoms') is-invalid @enderror"
                                      placeholder="Describe the symptoms..." required>{{ old('symptoms', $medicalRecord->symptoms) }}</textarea>
                            @error('symptoms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="treatment">Treatment <span class="text-danger">*</span></label>
                            <textarea name="treatment" id="treatment" rows="4"
                                      class="form-control @error('treatment') is-invalid @enderror"
                                      placeholder="Describe the treatment provided..." required>{{ old('treatment', $medicalRecord->treatment) }}</textarea>
                            @error('treatment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Medical Record
                            </button>
                            <a href="{{ route('medical-records.show', $medicalRecord) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Details
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
