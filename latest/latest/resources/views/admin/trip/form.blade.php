@extends('layouts.app')

@section('title', $mode == 'add' ? 'Add Trip' : 'Edit Trip')

@section('content')

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            {{-- Alert Messages --}}
            @include('common.alert')

        <div class="card"> 
          <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ $mode == 'add' ? 'Add Trip' : 'Edit Trip' }}</h4>
                        <div class="page-title-right">
                            <a href="{{ route('trip.index') }}"
                                class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>

             <form method="POST" action="{{ $mode == 'add'  ? route('trip.store') : route('trip.update', $trip->trip_id) }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Trip Date <span class="text-danger">*</span></label>

                        <input type="date" name="trip_date" class="form-control"
                            value="{{ old('trip_date', $trip->trip_date ?? date('Y-m-d')) }}"
                            required>

                        @if($errors->has('trip_date'))
                            <span class="text-danger">{{ $errors->first('trip_date') }}</span>
                        @endif
                    </div>


                    <div class="col-md-6 mb-4">
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
                        @if($errors->has('truck_id'))
                            <span class="text-danger">{{ $errors->first('truck_id') }}</span>
                        @endif
                    </div>

                    <div class="col-md-6 mb-4">
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
                        @if($errors->has('driver_id'))
                            <span class="text-danger">{{ $errors->first('driver_id') }}</span>
                        @endif
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Product <span class="text-danger">*</span></label>
                        <input type="text" name="product" class="form-control" value="{{ old('product', $trip->product ?? '') }}" required>
                        @if($errors->has('product'))
                            <span class="text-danger">{{ $errors->first('product') }}</span>
                        @endif
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Source Address<span class="text-danger">*</span></label>
                        <input type="text" name="source" class="form-control" value="{{ old('source', $trip->source ?? '') }}" required>
                        @if($errors->has('source'))
                            <span class="text-danger">{{ $errors->first('source') }}</span>
                        @endif
                    </div>
                    <div class="col-md-6 mb-4">
                         <label class="form-label">Destination Address<span class="text-danger">*</span></label>
                        <input type="text" name="destination" class="form-control" value="{{ old('destination', $trip->destination ?? '') }}" required>
                        @if($errors->has('destination'))
                            <span class="text-danger">{{ $errors->first('destination') }}</span>
                        @endif

                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label">No Of Packet <span class="text-danger">*</span></label>
                        <input type="text" name="no_of_bags" class="form-control" value="{{ old('no_of_bags', $trip->no_of_bags ?? '') }}" required>
                        @if($errors->has('no_of_bags'))
                            <span class="text-danger">{{ $errors->first('no_of_bags') }}</span>
                        @endif

                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Weight <span class="text-danger">*</span></label>
                        <input type="text" name="weight" class="form-control" value="{{ old('weight', $trip->weight ?? '') }}" required>
                        @if($errors->has('weight'))
                            <span class="text-danger">{{ $errors->first('weight') }}</span>
                        @endif

                    </div>
                </div>

                <button type="submit" class="btn btn-success">
                    {{ isset($trip) ? 'Update' : 'Submit' }}
                </button>
                @if(isset($trip))
                 <a href="{{ route('trip.index') }}" class="btn btn-light">
                    Cancel
                 </a>
                @else
                 <button type="reset" class="btn btn-light">
                    Clear
                </button>
                @endif
            </form>

        </div>
    </div>
 </div>
</div>
</div>
@endsection
