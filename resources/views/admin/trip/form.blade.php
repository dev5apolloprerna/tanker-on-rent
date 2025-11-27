@extends('layouts.app')

@section('title', $mode == 'add' ? 'Add Trip' : 'Edit Trip')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            @include('common.alert')

            <div class="row justify-content-center">
                <div class="col-md-12">

                    <div class="card shadow-sm">
                        <div class="card-body">

                            <h4 class="card-title mb-3">
                                {{ $mode == 'add' ? 'Add Trip' : 'Edit Trip' }}
                            </h4>
                            <div class="row">
                            <form method="POST"
                                  action="{{ $mode == 'add'
                                            ? route('trip.store')
                                            : route('trip.update', $trip->trip_id) }}">
                                @csrf

                                {{-- TRIP DATE --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Trip Date <span class="text-danger">*</span></label>
                                    <input type="date"
                                           name="trip_date"
                                           required
                                           class="form-control"
                                           value="{{ old('trip_date', $trip->trip_date ?? '') }}">
                                </div>

                                {{-- TRUCK --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Truck <span class="text-danger">*</span></label>
                                    <select name="truck_id" class="form-control" required>
                                        <option value="">Select Truck</option>
                                        @foreach($trucks as $truck)
                                            <option value="{{ $truck->truck_id }}"
                                                {{ old('truck_id', $trip->truck_id ?? '') == $truck->truck_id ? 'selected' : '' }}>
                                                {{ $truck->truck_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- DRIVER --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Driver <span class="text-danger">*</span></label>
                                    <select name="driver_id" class="form-control" required>
                                        <option value="">Select Driver</option>
                                        @foreach($drivers as $driver)
                                            <option value="{{ $driver->driver_id }}"
                                                {{ old('driver_id', $trip->driver_id ?? '') == $driver->driver_id ? 'selected' : '' }}>
                                                {{ $driver->driver_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- PRODUCT --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Product <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="product"
                                           class="form-control"
                                           required
                                           value="{{ old('product', $trip->product ?? '') }}">
                                </div>

                                {{-- SOURCE --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Source <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="source"
                                           class="form-control"
                                           required
                                           value="{{ old('source', $trip->source ?? '') }}">
                                </div>

                                {{-- DESTINATION --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Destination <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="destination"
                                           class="form-control"
                                           required
                                           value="{{ old('destination', $trip->destination ?? '') }}">
                                </div>

                                {{-- WEIGHT --}}
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Weight <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="weight"
                                           class="form-control"
                                           required
                                           value="{{ old('weight', $trip->weight ?? '') }}">
                                </div>

                                {{-- ACTION BUTTONS --}}
                                <button type="submit" class="btn btn-primary">
                                    {{ $mode == 'add' ? 'Save Trip' : 'Update Trip' }}
                                </button>

                                <a href="{{ route('trip.index') }}"
                                   class="btn btn-light float-end">
                                   Back
                                </a>

                            </form>
                        </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
