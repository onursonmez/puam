@extends('fronts.layouts.app')
@section('front-title')
    {{ __('messages.appointment.appointment_success') }}
@endsection
@section('front-content')
@php
        $styleCss = 'style';
    @endphp
    <section class="hero-content-section bg-white p-t-100 p-b-100">
        
            <div class="container p-t-30">
                <div class="col-12">
                    <div class="text-center my-3">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                        <h1>
                            {{ __('messages.appointment.appointment_success_title') }}
                        </h1>
                        <p class="text-muted" style="font-size: 1.2rem;">{{ __('messages.appointment.appointment_success_message') }}</p>
                    </div>
                </div>
            </div>
    </section>

    <section class="our-faqs-section bg-secondary">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class=" p-5">
                        

                        <div class="appointment-details bg-light rounded p-4 mb-4">
                            <h3 class="mb-4 text-primary">{{ __('messages.appointment.appointment_details') }}</h3>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold text-dark">{{ __('messages.appointment.appointment_unique_id') }}:</label>
                                    <p class="mb-0">{{ $appointment->appointment_unique_id }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold text-dark">{{ __('messages.appointment.patient') }}:</label>
                                    <p class="mb-0">{{ $appointment->patient->user->full_name }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold text-dark">{{ __('messages.doctor.doctor') }}:</label>
                                    <p class="mb-0">Dr. {{ $appointment->doctor->user->full_name }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold text-dark">{{ __('messages.common.service') }}:</label>
                                    <p class="mb-0">{{ $appointment->services->first()->name ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold text-dark">{{ __('messages.appointment.date') }}:</label>
                                    <p class="mb-0">{{ \Carbon\Carbon::parse($appointment->date)->format('d.m.Y') }}</p>
                                </div>
                                @php
                                    $from = \Carbon\Carbon::createFromFormat('h:i A', $appointment->from_time . ' ' . $appointment->from_time_type);
                                    $to = \Carbon\Carbon::createFromFormat('h:i A', $appointment->to_time . ' ' . $appointment->to_time_type);
                                @endphp

                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold text-dark">{{ __('messages.appointment.time') }}:</label>
                                    <p class="mb-0">{{ $from->format('H:i') }} - {{ $to->format('H:i') }}</p>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold text-dark">{{ __('messages.patient.email') }}:</label>
                                    <p class="mb-0">{{ $appointment->patient->user->email }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold text-dark">{{ __('messages.web.phone') }}:</label>
                                    <p class="mb-0">{{ $appointment->patient->user->phone ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold text-dark">{{ __('messages.appointment.payment_status') }}:</label>
                                    <p class="mb-0">
                                        @if($appointment->payment_type == \App\Models\Appointment::PAID)
                                            <span class="badge bg-success">{{ __('messages.filter.paid') }}</span>
                                        @elseif($appointment->payment_type == \App\Models\Appointment::PENDING)
                                            <span class="badge bg-warning">{{ __('messages.filter.awaited') }}</span>
                                        @else
                                            <span class="badge bg-info">{{ __('messages.filter.manual_payment') }}</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="fw-bold text-dark">{{ __('messages.purchase_medicine.amount') }}:</label>
                                    <p class="mb-0 fw-bold text-primary">{{ getCurrencyIcon() }} {{ number_format($appointment->payable_amount, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .appointment-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 80px 0;
        }
        
        .appointment-success-section {
            margin-top: -50px;
            position: relative;
            z-index: 2;
        }
        
        .appointment-success-card {
            border: none;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .success-icon {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
        
        .appointment-details {
            border-left: 4px solid #28a745;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            transition: transform 0.2s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
@endsection
