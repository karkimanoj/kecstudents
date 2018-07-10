@extends('layouts.app')

@section('content')
<form method="POST" action="{{route('user.events.store')}}" >

	{{csrf_field()}}
	Title: <input type="text" name="title" maxlength="191"><br><br>
	Type: <select name="type">
		<option value="study">study</option>
		<option value="entertainment">entertainment</option>
		<option value="miscellaneous">miscellaneous</option>
	</select><br><br>
	venue: <input type="text" name="venue"><br><br>
	start date-time:<input type="date" name="start_date"> <input type="time" name="start_time"><br><br>
	End date-time:<input type="date" name="end_date"> <input type="time" name="end_time"><br><br>
	max_members: <input type="number" name="max_members"><br><br>
	description: <textarea name="description"></textarea><br><br>
	<input type="submit" name="submit" value="submit">

</form>
@endsection