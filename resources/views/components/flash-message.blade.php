@if (session()->has('message'))
<div x-data="{show: true}" x-init="setTimeout(() => show = false, 4000)" x-show="show"
    style="position: fixed; bottom: 0; right: 10; z-index: 5;"
    class="alert alert-success" role="alert">
    <strong>
        {{ session('message') }}
    </strong>
    <button @click= "show = false" type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif