<table width="100%" style="font-family:arial;font-size:12px;">
	<tr>
		<td><font color="blue" size="+1">PHILSAGA MINING CORPORATION</font><br>
			Purok 1-A, Bayugan 3, Rosario, Agusan del Sur<br><br></td>
		<td align="right" style="font-size:11px;" valign="top">{{ date('F d,Y') }}</td>
	</tr>
</table>

<table width="100%">
	<tr>
		<td align="center">
			<font color="blue" size="+1">Downtime List</font><br>
			As of: {{ date('F d,Y') }}<br><br><br><br>
		</td>
	</tr>
</table>

<table width="100%" style="font-family:arial;font-size:12px;">
	
	<thead>
		<tr align="left">
			<th>Unit</th>
			<th>Start</th>
			<th>End</th>
			<th>Planned</th>
			<th>Total<br>Minutes</th>
			<th>Remarks</th>												
		</tr>
	</thead>
	
	<tbody>
		
		<tr><td colspan="6"><hr></td></tr>

		@foreach( $downtime as $down )

			<tr>
				<td>{{ $down->unit->name }}</td>
				<td>{{ $down->start_date->toFormattedDateString() }}</td>
				<td>{{ $down->end_date->toFormattedDateString() }}</td>
				<td>
					@if( $down->is_scheduled == 0 )
						Unscheduled
					@elseif( $down->is_scheduled == 1 )
						Scheduled
					@else
						Grid Outage
					@endif
				</td>
				<td>{{ $down->start_date->diffInMinutes($down->end_date) }}</td>
				<td>{{ $down->remarks }}</td>
			</tr>

		@endforeach

	</tbody>

</table>
<br><br><br><br>

<table width="100%" style="font-family:Arial;font-size:12px;font-weight:bold;">
    <tr>
        <td>Prepared by:</td>
        <td>Checked by:</td>
        <td>Noted by:</td>
    </tr>
    <tr>
        <td>_______________________</td>
        <td>_______________________</td>
        <td>_______________________</td>
    </tr>
</table>