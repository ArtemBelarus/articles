<div class="card card-body mt-3">
    <h4>Eans:</h4>
    <ul class="list-group mb-3">
        @foreach($eans as $ean)
            <li class="list-group-item">{{ $ean->value }}
                <div class="float-right">
                    <form class="d-inline" method="POST"
                          action="{{ route('eans.destroy', [$article->id, $ean->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
    <form method="POST" action="{{ route('eans.store', $article->id) }}">
        @csrf
        <label for="ean">Add new ean:</label>
        <div class="form-group row">
            <div class="col-9">
                <input id="ean" maxlength="128" type="text" class="form-control" name="value"
                       placeholder="ean value*" required>
            </div>
            <div class="col-3">
                <button class="btn btn-primary" type="submit">Add</button>
            </div>
        </div>
    </form>
</div>