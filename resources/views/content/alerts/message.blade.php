@if(session()->has('message'))
    <div class="row mr-2 ml-2">
            <button type="text" class="btn btn-lg btn-block btn-outline-success mb-2"
                    id="type-error">{{ session()->get('message') }}
            </button>
    </div>
@endif
