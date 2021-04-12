<div class="card card-body mt-3">
    <h4>Original codes:</h4>
    <ul class="list-group mb-3">
        @foreach($originalCodes as $originalCode)
            <li class="list-group-item">{{ $originalCode->value }}
                <div class="float-right">
                    <form class="d-inline" method="POST"
                          action="{{ route('original_codes.destroy', [$article->id, $originalCode->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
    <form method="POST" action="{{ route('original_codes.store', $article->id) }}">
        @csrf
        <label for="original_code">Add new original code:</label>
        <div class="form-group row">
            <div class="col-9">
                <input id="original_code" maxlength="128" type="text" class="form-control" name="value"
                       placeholder="code value*" required>
            </div>
            <div class="col-3">
                <button class="btn btn-primary" type="submit">Add</button>
            </div>
        </div>
    </form>
</div>