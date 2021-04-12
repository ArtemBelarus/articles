@extends('layouts.app')

@section('title')
    Articles list
@endsection

@section('content')
    <div class="row">
        <div class="offset-lg-2 col-lg-8 mb-3">
            <h2>Articles</h2>
            <div class="text-right">
                <a class="btn btn-primary" href="{{ route('articles.create') }}">Create new article</a>
            </div>
        </div>

        @include('articles.partials.filter')

        <div class="offset-lg-2 col-lg-8">
            @if ($articles->count())
                <ul class="list-group mb-3">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-2 col-2">ID</div>
                            <div class="col-sm-7 col-7">Number</div>
                            <div class="col-sm-3 col-3 text-right">Controls</div>
                        </div>
                    </li>
                    @foreach($articles as $article)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-sm-2 col-2"><strong>{{ $article->id }}</strong></div>
                                <div class="col-sm-7 col-10">
                                    @php
                                        $originalCodes = $article->original_codes;
                                        $relatedNumbers = $article->related_numbers;
                                        $eans = $article->eans;
                                    @endphp
                                    {{ $article->number }}
                                    @if ($originalCodes->count() > 0)
                                        <div>
                                            <small>Original
                                                codes: {{ implode(', ', $originalCodes->pluck('value')->all()) }}</small>
                                        </div>
                                    @endif
                                    @if ($relatedNumbers->count() > 0)
                                        <div>
                                            <small>Related
                                                numbers: {{ implode(', ', $relatedNumbers->pluck('value')->all()) }}</small>
                                        </div>
                                    @endif
                                    @if ($eans->count() > 0)
                                        <div>
                                            <small>Eans: {{ implode(', ', $eans->pluck('value')->all()) }}</small>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-3 col-12 text-right">
                                    <a class="btn btn-sm btn-primary"
                                       href="{{ route('articles.edit', $article->id) }}">Edit</a>
                                    <form class="d-inline" method="POST"
                                          action="{{ route('articles.destroy', $article->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                {{ $articles->appends(request()->input())->links() }}
            @else
                <div class="alert alert-warning m-0">No articles found.</div>
            @endif
        </div>
    </div>
@endsection