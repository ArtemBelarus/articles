<div class="card card-body mt-3">
    <h4>Related numbers:</h4>
    <ul class="list-group mb-3">
        @foreach($relatedNumbers as $relatedNumber)
            <li class="list-group-item">{{ $relatedNumber->value }}
                <div class="float-right">
                    <form class="d-inline" method="POST"
                          action="{{ route('related_numbers.destroy', [$article->id, $relatedNumber->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
    <form method="POST" action="{{ route('related_numbers.store', $article->id) }}">
        @csrf
        <label for="related_number">Add new related number:</label>
        <div class="form-group row">
            <div class="col-9">
                <input id="related_number" maxlength="128" type="text" class="form-control" name="value"
                       placeholder="related number value*" required>
            </div>
            <div class="col-3">
                <button class="btn btn-primary" type="submit">Add</button>
            </div>
        </div>
    </form>
</div>