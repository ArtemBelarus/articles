<div class="offset-lg-2 col-lg-8 mb-4">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="m-0 pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="GET" action="{{ route('articles.index') }}">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                <label for="number" class="form-label">Article number</label>
                <input id="number" maxlength="128" type="text" class="form-control" name="number"
                       value="{{ $filter['number'] }}">
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                <label for="code_type" class="form-label">Code type</label>
                <select name="code_type" id="code_type" class="form-control" autocomplete="off">
                    <option value="original_codes" @if ($filter['code_type'] === 'original_codes') selected @endif>
                        Original code
                    </option>
                    <option value="related_numbers" @if ($filter['code_type'] === 'related_numbers') selected @endif>
                        Related number
                    </option>
                    <option value="eans" @if ($filter['code_type'] === 'eans') selected @endif>
                        Ean
                    </option>
                </select>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                <label for="code_value" class="form-label">Code value</label>
                <input id="code_value" maxlength="128" type="text" class="form-control" name="code_value"
                       value="{{ $filter['code_value'] }}">
            </div>
            <div class="col-12 mb-1 text-right">
                <button class="btn btn-primary">Search</button>
                <a class="btn btn-danger" href="{{ route('articles.index') }}">Clear</a>
            </div>
        </div>
    </form>
</div>