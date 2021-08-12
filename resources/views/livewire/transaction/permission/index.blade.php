<div>
@if(Route::is('permission'))
    <livewire:transaction.permission.show/>
@endif
@if(Route::is('my-permission'))
	 <livewire:transaction.permission.show-my/>
 @endif

	 <livewire:transaction.permission.create/>
</div>