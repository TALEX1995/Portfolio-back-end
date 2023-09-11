@if ($errors->any())
  <div class="alert alert-danger mt-2">
    <ul>
      @foreach ($errors->all() as $e)
        <li>{{ $e }}</li>
      @endforeach
    </ul>
  </div>
@endif

@if (session()->has('message'))
  <div class="alert alert-success mt-2">
    {{ session('message') }}
  </div>
@endif
