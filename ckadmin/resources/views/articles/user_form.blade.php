
 @section('css')
    <link rel="stylesheet" href="{{ asset('css/bootstrap-imageupload.css') }}">
@stop

<div class="form-group">
    <label for="catname" class="col-sm-2 control-label"> Name <span class="required" aria-required="true">*</span> </label>
    <div class="col-sm-4">
        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Full Name">
        @if ($errors->has('name'))
            <label id="name-error" class="error" for="name"> {{ $errors->first('name') }}</label>
        @endif
    </div>
</div>

<div class="form-group">
    <label for="catname" class="col-sm-2 control-label"> Email <span class="required" aria-required="true">*</span> </label>
    <div class="col-sm-4">
        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Emaill Address">
        @if ($errors->has('email'))
            <label id="email-error" class="error" for="email"> {{ $errors->first('email') }}</label>
        @endif
    </div>
</div>

<div class="form-group">
    <label for="catname" class="col-sm-2 control-label"> Password <span class="required" aria-required="true">*</span> </label>
    <div class="col-sm-4">
        <input type="password" class="form-control" name="password" placeholder="Password">
        @if ($errors->has('password'))
            <label id="password-error" class="error" for="password"> {{ $errors->first('password') }}</label>
        @endif
    </div>
</div>

<div class="form-group">
    <div class="col-md-6 col-md-offset-2">
        <button type="submit" class="btn btn-primary">
            Save
        </button>
    </div>
</div>

@section('script')
     <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="crossorigin="anonymous"></script>
    <script src="{{ asset('js/bootstrap-imageupload.js') }}"></script>

 <script>
    var $imageupload = $('.imageupload');
    $imageupload.imageupload();
</script>

@stop



