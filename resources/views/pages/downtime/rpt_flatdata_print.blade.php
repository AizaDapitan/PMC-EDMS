<table width="100%" style="font-style:Arial;font-size:14px;">
	<tr>
		<td colspan="3" align="center" style="font-style:Arial;font-size:16px;font-weight:bold;"><br><br>Downtime Report</td>
	</tr>
	<tr>
		<td colspan="3" align="center">
			@if( request()->startdate )
				<strong>From:</strong> {{ \Carbon\Carbon::parse(request()->startdate)->toFormattedDateString() }} 
				&nbsp;
				<strong>To:</strong> {{ \Carbon\Carbon::parse(request()->enddate)->toFormattedDateString() }}
			@else
				{{ date('F d,Y') }}
			@endif
		</td>
	</tr>			
</tr>
	<tr style="font-weight:bold;color:blue;">
		<td>Unit</td>
		<td>Mins</td>
		
		<td>Availability %</td>
 	</tr>	
 	<tr><td colspan="3"><hr></td></tr>							
 	@foreach( $displayData as $key => $down )
 		<tr>
 			<td>{{ $key }}</td>
 			<td>{{ $down['mins'] }}</td>
 			<td>{{ number_format( 100 - $down['availability'], 2) }}%</td>
 		</tr>
 	@endforeach
	<tr><td colspan="3"><hr></td></tr>
</table>