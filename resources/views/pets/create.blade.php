@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('pets.headers.pet_add') }}</div>

                    <div class="card-body">
                        <form class="needs-validation" method="POST" action="{{ route('pets.store') }}" novalidate>
                            @csrf

                            <div class="row mb-3">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-end">{{ __('pets.input.name') }} <span style="color: red;">*</span></label>

                                <div class="col-md-6">
                                    <input id="name" maxlength="100" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="category"
                                       class="col-md-4 col-form-label text-md-end">{{ __('pets.input.category') }} <span style="color: red;">*</span></label>

                                <div class="col-md-6">
                                    <select class="form-control @error('category') is-invalid @enderror" name="category" id="petCategories">
                                        <option value="" selected> {{ __('pets.fields.choose') }} </option>
                                        @foreach(\App\Constants\PetCategory::PET_CATEGORIES as $categoryId => $categoryName)
                                            <option
                                                value="{{ $categoryId }}" @selected(old('category', '') == $categoryId)>{{ $categoryName }}</option>
                                        @endforeach
                                    </select>

                                    @error('category')
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
                                        <option value="" selected>{{ __('pets.fields.choose') }}</option>
                                        @foreach(\App\Enums\PetStatus::cases() as $status)
                                            <option
                                                value="{{ $status->value }}" @selected(old('status', '') == $status->value)>{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="status"
                                       class="col-md-4 col-form-label text-md-end">{{ __('pets.input.tags') }}</label>
                                <div class="col-md-6">
                                    <select class="form-control multi-select" name="tags[]" multiple="true"
                                            id="petTags">
                                        @foreach(\App\Constants\PetTag::PET_TAGS as $tagId => $tagName)
                                            <option value="{{ $tagId }}" {{ in_array($tagId, old('tags', $selectedTags)) ? 'selected' : '' }}>{{ $tagName }}</option>
                                        @endforeach
                                    </select>

                                    @error('category.name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <input type="hidden" id="tagsData" name="tagsData" value="">
                            <input type="hidden" id="categoriesData" name="categoriesData" value="">

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('pets.button.add') }}
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

@section('scripts')
    <script>
        $(document).ready(function () {
            $('#tagsData').val('{{ old('tagsData') }}');
            $('#categoriesData').val('{{ old('categoriesData') }}');

            $(".multi-select").select2({
                placeholder: " Select tag",
                tags: true,
            });

            $('#petTags').change(function () {
                var selectedTags = [];
                $('#petTags option:selected').each(function () {
                    const tagId = $(this).val();
                    const tagName = $(this).text();
                    selectedTags.push({id: tagId, name: tagName});
                });
                $('#tagsData').val(JSON.stringify(selectedTags));
            });

            $('#petCategories').change(function () {
                var selectedCategories = [];
                $('#petCategories option:selected').each(function () {
                    const categoryId = $(this).val();
                    const categoryName = $(this).text();
                    selectedCategories.push({id: categoryId, name: categoryName});
                });
                $('#categoriesData').val(JSON.stringify(selectedCategories));
            });
        })
    </script>
@endsection



