@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
{{ Form::model($message, ['url' => route('messages.store')]) }}
@include('message.form')
{{ Form::submit('Сохранить') }}
{{ Form::close() }}
