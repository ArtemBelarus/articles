@extends('layouts.app')

@section('title')
    @if ($isNew) Create @else Edit @endif article
@endsection

@section('content')
    <div class="row">
        <div class="offset-lg-2 col-lg-8">
            <h2><a class="btn btn-sm btn-primary mr-3" href="{{ route('articles.index') }}">&larr; Back</a>
                @if ($isNew) Create @else Edit @endif article</h2>
        </div>
        <div class="offset-lg-2 col-lg-8">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="m-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card card-body">
                <form method="POST"
                      action="{{ $isNew ? route('articles.store') : route('articles.update', $article->id) }}">
                    @csrf
                    @if (!$isNew)
                        @method('PUT')
                    @endif
                    <div class="form-group row">
                        <label for="number" class="col-md-6 col-form-label">Article number*</label>
                        <div class="col-md-6">
                            <input id="number" maxlength="128" type="text" class="form-control" name="number"
                                   value="{{ old('number', $article->number) }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </div>
                </form>
            </div>

            @if (!$isNew)
                @include('articles.partials.original_codes')
                @include('articles.partials.related_numbers')
                @include('articles.partials.eans')
            @endif
        </div>
    </div>
@endsection