@extends('layouts.app')

@section('content')

    <div class="container">
        @include('helpers.flash-messages')
        <div class="row">
            <div class="col-6">
                <h1><i class="fa-solid fa-paw"></i> Lista zwierzaków </h1>
            </div>
            <div class="col-6">
                <a class="float-end" href="{{ route('pets.create') }}">
                    <button type="button" class=" btn btn-primary"><i class="far fa-plus"></i> Dodaj</button>
                </a>
            </div>
        </div>
        <br>
        <div class="col-6">
            <label for="status">Status:</label>
            <form action="{{ route('pets.index') }}" method="GET">
                <select id="status" name="status" class="form-control" onchange="this.form.submit()">
                    @foreach(\App\Enums\PetStatus::cases() as $status)
                        <option value="{{ $status->value }}" {{ $selectedStatus === $status->value ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
        <br>
        <div class="row table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col"># ID</th>
                    <th scope="col">Nazwa</th>
                    <th scope="col">Kategoria</th>
                    <th scope="col">Status</th>
                    <th scope="col">Akcje</th>
                </tr>
                </thead>
                <tbody>
                @forelse($pets as $pet)
                    <tr>
                        <th scope="row">{{ $pet['id'] }}</th>
                        <td>{{ $pet['name'] ?? 'Brak imienia' }}</td>
                        <td>{{ $pet['category']['name'] ?? 'Brak kategorii'}}</td>
                        <td>{{ $pet['status'] }}</td>
                        <td>
                            <a href="{{ route('pets.edit', $pet['id']) }}"
                               class="btn btn-success btn-sm"><i class="far fa-edit"></i></a>
                            <form class="d-inline" action="{{ route('pets.delete', $pet['id']) }}" method="POST">
                                @method('DELETE')
                                @csrf
                            <button class="btn btn-danger btn-sm delete" onclick="return confirm('Czy jesteś pewien?')"
                                    ><i class="far fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <td class="text-center" colspan="4">{{ __('Brak wyników') }}</td>
                @endforelse
                </tbody>
            </table>
            {{ $pets->appends(['status' => $selectedStatus])->links() }}
        </div>
    </div>

@endsection



