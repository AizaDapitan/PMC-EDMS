<table width="100%" style="font-style:Arial;font-size:14px;">
	<tr>
		<td colspan="12" align="center" style="font-style:Arial;font-size:16px;font-weight:bold;"><br><br>Downtime List Raw Data</td>
	</tr>
	<tr>
		<td colspan="12" align="center">{{ date('F d Y') }}<br><br></td>
	</tr>			
</tr>
	<tr style="font-weight:bold;color:blue;">
		<td>Seq</td>
		<td>Unit ID</td>
		<td>Name</td>
		<td>Location</td>
		<td>Type</td>
		<td>Date Start</td>
		<td>Date End</td>
		<td>Remarks</td>
		<td>Added By</td>
		<td>Added Date</td>
		<td>Downtime Type</td>
 	</tr>	
 	<tr><td colspan="12"><hr></td></tr>							
 	@foreach( $downtime as $key => $down )
	<tr style=" background:{{ $key%2 == 0 ? '#ffffff':'#F6F7F6'}}">
		<td width="2%">{{ $key + 1 }}</td>
		<td width="3%">{{ $down->id }}</td>
		<td width="16%">{{ $down->unit ? $down->unit->name : '' }}</td>
		<td width="5%">{{ $down->unit ? $down->unit->location : '' }}</td>
		<td width="15%">{{ $down->unit ? $down->unit->type : '' }}</td>
		<td width="7%">{{ $down->start_date->toFormattedDateString() }}</td>
		<td width="7%">{{ $down->end_date->toFormattedDateString() }}</td>
		<td width="20%">{{ $down->remarks }}</td>
		<td width="10%">{{ $down->added_by }}</td>
		<td width="10%">{{ $down->created_at->toFormattedDateString() }}</td>
		<td>
			@if( $down->is_scheduled == 0 )
				Unscheduled
			@elseif( $down->is_scheduled == 1 )
				Scheduled
			@else
				Grid Outage
			@endif
		</td>
	</tr>
	@endforeach
	<tr><td colspan="12"><hr></td></tr>
</table>