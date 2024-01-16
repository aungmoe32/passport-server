<x-filament-panels::page>
	<div>
		@if($connected)
		    @if($user)
			    <div>Name : {{ $user['name'] }}</div>
			    <div>Email : {{ $user['email'] }}</div>
		    @else
		    	<div>Expired Token!</div>
	    	@endif
    	@else

    	<div>Not Connected</div>
    @endif
	</div>
    
</x-filament-panels::page>
