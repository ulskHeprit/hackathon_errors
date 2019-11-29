messages here
@foreach($messages as $message)
    <p><a href="{{ route('messages.show', $message) }}">{{ $message->message }}</a></p>
    <p>date: {{ $message->updated_at }}</p>
    <hr>
@endforeach
