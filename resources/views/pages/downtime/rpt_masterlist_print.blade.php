<table width="100%" style="font-style:Arial;font-size:14px;">
	<tr>
		<td colspan="5" align="center" style="font-style:Arial;font-size:16px;font-weight:bold;"><br><br>Masterlist</td>
	</tr>
	<tr>
		<td colspan="5" align="center">{{ date('F d Y') }}<br><br></td>
	</tr>			
</tr>
	<tr style="font-weight:bold;color:blue;">
		<td>Seq</td>
		<td>Name</td>
		<td>Location</td>
		<td>Type</td>
 	</tr>	
 	<tr><td colspan="5"><hr></td></tr>							
 	@foreach( $units as $key => $unit )
	<tr style=" background:{{ $key%2 == 0 ? '#ffffff':'#F6F7F6'}}">
		<td>{{ $key + 1 }}</td>
		<td>{{ $unit->name }}</td>
		<td>{{ $unit->location }}</td>
		<td>{{ $unit->type }}</td>
	</tr>
	@endforeach
	<tr><td colspan="5"><hr></td></tr>
</table>