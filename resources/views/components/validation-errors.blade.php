@if ($errors->any())
<div class="validation-alert">
    <div class="head">
        Form Not Yet Submitted!
    </div>
    <div class="body">
        <p>
            Sorry, but the form was not submitted! Please correct the following errors and try again. 
        </p>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif