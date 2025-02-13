@extends('layouts.master')
@section('title') @lang('translation.Google_Maps') @endsection
@section('content')


@section('pagetitle')Google Maps @endsection


    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Markers</h4>
                </div>
                <div class="card-body">
                    <p class="card-title-dsec">Example of google maps.</p>

                    <div id="gmaps-markers" class="gmaps"></div>
                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Overlays</h4>
                </div>
                <div class="card-body">
                    <p class="card-title-desc">Example of google maps.</p>

                    <div id="gmaps-overlay" class="gmaps"></div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->


    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Street View Panoramas</h4>
                </div>
                <div class="card-body">
                    <p class="card-title-desc">Example of google maps.</p>
                    <div id="panorama" class="gmaps-panaroma"></div>
                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Map Types</h4>
                </div>
                <div class="card-body">
                    <p class="card-title-desc">Example of google maps.</p>

                    <div id="gmaps-types" class="gmaps"></div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
@section('script')
    <script src="https://maps.google.com/maps/api/js?key="></script>

    <script src="{{ URL::asset('assets/libs/gmaps/gmaps.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/gmaps.init.js') }}"></script>
    <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
@endsection
