<div width="100%">

		<p align="center" style="font-family:'Open Sans', sans-serif;font-size:18px;color: rgb(0,0,255); margin-bottom: 1px;">
			<br><br>Equipment Up Time
		</p>

		<p align="center" style="font-family:'Open Sans', sans-serif;font-size:16px;margin-top: 0;">
			@if( request()->startdate )
				<strong>From:</strong> {{ \Carbon\Carbon::parse(request()->startdate)->toFormattedDateString() }} 
				&nbsp;
				<strong>To:</strong> {{ \Carbon\Carbon::parse(request()->enddate)->toFormattedDateString() }}
			@else
				As of: {{ date('F d,Y') }}<br>
			@endif
		</p>

</div>

<table width="100%" style="font-style:Arial;font-size:14px;">
	<tr style="font-weight:bold;color:blue;">
		<td class="text-center"> # </td>
		<td class="text-center"> Units </td>
		@foreach( $displayDate as $date )
			<td class="text-center"> {{ $date }}</td>
		@endforeach
 	</tr>
 	<tr><td colspan="{{count($displayData)}}"><hr></td></tr>							
 	@php $count = 1; @endphp
	@foreach( $displayData as $key => $data )
		<tr>
			<td class="text-center"> {{ $count }} </td>
			<td class="text-center"><strong> {{ $key }} </strong></td>
			@foreach( $data as $d )
				<td class="text-center">
				 	{{ number_format( (1440 - $d['mins']) / 60, 2) }}
				 </td>
			@endforeach
		</tr>
		@php $count++; @endphp
	@endforeach
 	<tr><td colspan="{{count($displayData)}}"><hr></td></tr>							
</table>
