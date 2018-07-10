@extends('layouts.app')

@section('content')

<h4>{{$event->start_time}}</h4>
<form method="POST" action="{{route('user.events.update', $event->id)}}" >
	{{method_field('PUT')}}
	{{csrf_field()}}
	Title: <input type="text" name="title" maxlength="191" value="{{$event->title}}"><br><br>
	Type: <select name="type">
		<option value="study">study</option>
		<option value="entertainment">entertainment</option>
		<option value="miscellaneous">miscellaneous</option>
	</select><br><br>
	venue: <input type="text" name="venue" value="{{$event->venue}}"><br><br>
	

	start date-time:<input type="date" name="start_date" value="{{$event->start_date}}"> <input type="time" name="start_time" value="{{$event->start_time}}"><br><br>
	End date-time:<input type="date" name="end_date" value="{{$event->end_date}}"> <input type="time" name="end_time" value="{{$event->end_time}}"><br><br>
	max_members: <input type="number" name="max_members" value="{{$event->max_members}}"><br><br>
	description: <textarea name="description">{{$event->description}}"</textarea><br><br>
	<input type="submit" name="submit" value="submit">

</form>

@endsection