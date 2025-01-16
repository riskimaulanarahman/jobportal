@extends('layouts.master')
@section('title') @lang('My-Applied') @endsection
@section('css')
<style>
    .stepper {
        list-style-type: none;
        display: flex;
        justify-content: space-around;
        padding: 0;
        margin: 20px 0;
        position: relative;
    }

    .step {
        text-align: center;
        width: 100%;
        padding: 10px;
        cursor: pointer;
        font-size: 14px;
        color: #666;
        position: relative;
        transition: all 0.3s ease;
    }

    .step::after {
        content: '';
        position: absolute;
        top: 20px;
        left: 50%;
        width: 100%;
        height: 2px;
        background-color: #d3d3d3;
        z-index: -1;
        transform: translateX(-50%);
    }

    .step.completed::after {
        background-color: #0d6efd;
        z-index: -1;
    }

    .step:first-child::after {
        content: none; /* Remove line for the first step */
    }

    .step::before {
        content: attr(data-icon);
        display: block;
        margin: 0 auto 8px;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        line-height: 30px;
        background-color: #ddd;
        color: #888;
        font-size: 14px;
    }

    .step.completed::before {
        content: "\2713"; /* Checkmark */
        background-color: #0d6efd;
        color: white;
    }

    .step.active::before {
        background-color: #0d6efd;
        color: white;
    }

    .step.active {
        font-weight: bold;
        color: #0d6efd;
    }

    .step.completed {
        color: #0d6efd;
    }

    @media (max-width: 768px) {
        .stepper {
            flex-direction: column;
            align-items: center;
        }

        .step {
            width: auto;
        }

        .step::after {
            content: none;
        }
    }

    .checkmark {
        font-weight: bold;
        margin-left: 5px;
    }

</style>
@endsection
@section('content')
@section('pagetitle') <small>My Applied Jobs</small> @endsection

<div class="container mt-5">
    <!-- Card for Job 1 -->
    <div class="card mb-3">
        <div class="card-header">
            <h4>Software Engineer</h4>
            <button class="btn btn-link toggle-detail" data-bs-toggle="collapse" data-bs-target="#job1Details" aria-expanded="false" aria-controls="job1Details">Show Detail</button>
        </div>
        <div class="collapse" id="job1Details">
            <div class="card-body">
                <!-- Stepper Component -->
                <ul class="stepper">
                    <li class="step completed" data-target="#formPhase1">Screening</li>
                    <li class="step completed" data-target="#formPhase2">Psycho Test</li>
                    <li class="step active" data-target="#formPhase3">Interview</li>
                    <li class="step" data-target="#formPhase4">HR Review</li>
                    <li class="step" data-target="#formPhase5">Offering Letter</li>
                    <li class="step" data-target="#formPhase6">MCU</li>
                    <li class="step" data-target="#formPhase7">Hired</li>
                </ul>
                
                <!-- Dynamic Form Display -->
                <div class="mt-4">
                    <div id="formPhase1" class="form-steps d-none">
                        <h5>Screening Phase</h5>
                        <div class="text-center mt-5">
                            <div class="card border shadow-none card-body text-muted mb-0">
                                {{-- <span>Status : Waiting <i class="fas fa-hourglass"></i></span> --}}
                                <span>Status : Approved <i class="fas fa-check"></i></span>
                            </div>
                        </div>
                    </div>
                    <div id="formPhase2" class="form-steps d-none">
                        <h5>Psycho Test Phase</h5>
                        <div class="text-center mt-5">
                            <div class="card border shadow-none card-body text-muted mb-0">
                                {{-- <span>Status : Waiting Test Schedule <i class="fas fa-hourglass"></i></span> --}}
                                <span>Status : Approved <i class="fas fa-check"></i></span>
                            </div>
                        </div>
                    </div>
                    <div id="formPhase3" class="form-steps d-none">
                        <h5>Interview Phase</h5>
                        <div class="text-center mt-5">
                            <div class="card border shadow-none card-body text-muted mb-0">
                                <span>Status : Waiting Interview Schedule <i class="fas fa-hourglass"></i></span>
                                {{-- <span>Status : Approved <i class="fas fa-check"></i></span> --}}
                            </div>
                        </div>
                    </div>
                    <!-- Add forms for other phases similarly -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle show/hide detail button text
        document.querySelectorAll('.toggle-detail').forEach(button => {
            button.addEventListener('click', function () {
                let isExpanded = this.getAttribute('aria-expanded') === 'true';
                this.textContent = isExpanded ? 'Hide Detail' : 'Show Detail';
                this.setAttribute('aria-expanded', !isExpanded);
            });
        });

        // Step click handling
        document.querySelectorAll('.card').forEach(card => {
            card.querySelectorAll('.step').forEach(step => {
                // Allow only completed or active steps to be clicked
                if (!step.classList.contains('completed') && !step.classList.contains('active')) {
                    step.style.pointerEvents = 'none';
                    return;
                }

                step.addEventListener('click', function () {
                    // Hide all form-steps in the current card body
                    card.querySelectorAll('.form-steps').forEach(formStep => formStep.classList.add('d-none'));
                    
                    // Show target form-step
                    let target = card.querySelector(this.getAttribute('data-target'));
                    if (target) {
                        target.classList.remove('d-none');
                    }
                });
            });

            // On page load, show the form for any active step
            let activeStep = card.querySelector('.step.active');
            if (activeStep) {
                let target = card.querySelector(activeStep.getAttribute('data-target'));
                if (target) target.classList.remove('d-none');
            }
        });
    });
</script>
    <script src="{{ URL::asset('assets/libs/wnumb/wnumb.min.js') }}"></script>
@endsection
