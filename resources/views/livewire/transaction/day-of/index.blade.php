<div>
@if(Route::is('day-of'))
    <livewire:transaction.day-of.show/>
@endif
@if(Route::is('my-day-of'))
	 <livewire:transaction.day-of.show-my/>
 @endif
	<livewire:transaction.day-of.detail/>
	<livewire:transaction.day-of.create/>

</div>