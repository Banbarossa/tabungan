<div>
    @if(auth()->user()->role === 'admin')
    <livewire:admin.dashboard.admin-dasboard/>
    @endif
    @if(auth()->user()->role === 'cashier')
    <livewire:cashier.dashboard.cashier-dashboard/>
    @endif
</div>
