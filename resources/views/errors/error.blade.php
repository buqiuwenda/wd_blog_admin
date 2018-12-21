<div class="form-group">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul class="text-box text-danger">
                @foreach ($errors->all() as $key=>$error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>