@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('pets.headers.pet_edit', ['name' => $pet['name']]) }}</div>

                    <div class="card-body">
                        <form class="needs-validation" method="POST" action="{{ route('pets.update', $pet['id']) }}" novalidate>
                            @csrf

                            <div class="row mb-3">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-end">{{ __('pets.input.name') }} <span style="color: red;">*</span></label>

                                <div class="col-md-6">
                                    <input id="name" maxlength="100" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name', $pet['name']) }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="status"
                                       class="col-md-4 col-form-label text-md-end"> {{ __('pets.input.status') }} <span style="color: red;">*</span></label>

                                <div class="col-md-6">
                                    <select class="form-control @error('status') is-invalid @enderror" name="status">
                                        <option value="">Wybierz</option>
                                        @foreach(\App\Enums\PetStatus::cases() as $status)
                                            <option
                                                value="{{ $status->value }}" @selected(old('status', $pet['status'], '') == $status->value)>{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('pets.button.save') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection




