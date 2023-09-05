@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-6">
                <h1><i class="fa-solid fa-paw"></i> Lista zwierzaków </h1>
            </div>
            <div class="col-6">
                <a class="float-end" href="#">
                    <button type="button" class=" btn btn-primary"><i class="far fa-plus"></i> Dodaj</button>
                </a>
            </div>
        </div>
        <br>
        <div class="col-6">
            <label for="status">Status:</label>
            <form action="{{ route('pets.index') }}" method="GET">
                <select id="status" name="status" class="form-control" onchange="this.form.submit()">
                    <option value="pending" {{ $status === 'pending' ? 'selected' : '' }}>Oczekujący</option>
                    <option value="available" {{ $status === 'available' ? 'selected' : '' }}>Dostępny</option>
                    <option value="sold" {{ $status === 'sold' ? 'selected' : '' }}>Sprzedany</option>
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
                </tr>
                </thead>
                <tbody>
                @forelse($pets as $pet)
                    <tr>
                        <th scope="row">{{ $pet['id'] }}</th>
                        <td>{{ $pet['name'] ?? 'Brak imienia' }}</td>
                        <td>{{ $pet['category']['name'] ?? 'Brak kategorii'}}</td>
                        <td>{{ $pet['status'] }}</td>
                    </tr>
                @empty
                    <td class="text-center" colspan="4">{{ __('Brak wyników') }}</td>
                @endforelse
                </tbody>
            </table>
            {{ $pets->appends(['status' => $status])->links() }}
        </div>
    </div>

@endsection



