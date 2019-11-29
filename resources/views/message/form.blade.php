@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{ Form::label('user_id', 'User') }}
{{ Form::text('user_id') }}<br>
{{ Form::label('message', 'Содержание') }}
{{ Form::textarea('message') }}<br>
