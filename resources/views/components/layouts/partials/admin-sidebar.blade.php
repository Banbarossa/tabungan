<flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 ">
    <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

    <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
        <x-app-logo />
    </a>

    <flux:navlist variant="outline" class="mt-4">
        <flux:navlist.group class="grid">
            <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                wire:navigate>Dashboard
            </flux:navlist.item>
            <flux:navlist.group heading="Santri" expandable :expanded="Request::is('account*')">
                <flux:navlist.item href="{{ route('account.index', ['status' => 'aktif']) }}"
                    :current="Request::is('account/aktif')" wire:navigate>Aktif
                </flux:navlist.item>
                <flux:navlist.item href="{{ route('account.index', ['status' => 'nonaktif']) }}"
                    :current="Request::is('account/nonaktif')" wire:navigate>Tidak Aktif
                </flux:navlist.item>

            </flux:navlist.group>
            <flux:navlist.item icon="users" :href="route('user.index', ['role' => 'admin'])"
                :current="request()->routeIs('user.admin')" wire:navigate>Petugas
            </flux:navlist.item>

        </flux:navlist.group>
        <flux:navlist.group :heading="__('Transaction')" class="grid">
            <flux:navlist.item icon="banknotes" :href="route('transaction')"
                :current="request()->routeIs('transaction')" wire:navigate>Transaction
            </flux:navlist.item>
            <flux:navlist.item icon="cloud-arrow-up" :href="route('riwayat-topup-jajan')"
                :current="request()->routeIs('riwayat-topup-jajan')" wire:navigate>Topup Jajan
            </flux:navlist.item>
            <flux:navlist.item icon="arrow-path" :href="route('daily-history')"
                :current="request()->routeIs('daily-history')" wire:navigate>Daily History
            </flux:navlist.item>
            <flux:navlist.item icon="calendar-days" :href="route('calendar')" :current="request()->is('calendar')">
                Calendar
            </flux:navlist.item>
        </flux:navlist.group>
        <flux:navlist.group heading="Laporan" expandable :expanded="Request::is('laporan*')">
            <flux:navlist.item href="{{ route('laporan.filter') }}" :current="Request::is('laporan-filter')"
                wire:navigate>Harian
            </flux:navlist.item>
        </flux:navlist.group>
        {{-- <flux:navlist.group heading="Limit" expandable :expanded="Request::is('limit*')">
            <flux:navlist.item icon="tag" :href="route('limit.daily')"
                :current="request()->routeIs('limit.daily')" wire:navigate>Limit Harian
            </flux:navlist.item>
            <flux:navlist.item icon="tag" :href="route('limit.khusus')"
                :current="request()->routeIs('limit.khusus')" wire:navigate>Limit Khusus
            </flux:navlist.item>

        </flux:navlist.group> --}}



        </flux:navlist.group>


        <flux:navlist.group :heading="__('Pengaturan')" class="grid">
            <flux:navlist.group heading="Whatsapp" expandable :expanded="Request::is('whatsapp*')">

                <flux:navlist.item icon="cog-6-tooth" :href="route('whatsapp.setting')"
                    :current="request()->routeIs('whatsapp.setting')" wire:navigate>Pengaturan
                </flux:navlist.item>
                <flux:navlist.item icon="paper-airplane" :href="route('whatsapp.monitoring', ['status' => 'sent'])"
                    :current="Request::is('whatsapp/monitoring/sent')" wire:navigate>Terkirim
                </flux:navlist.item>
                <flux:navlist.item icon="clock" :href="route('whatsapp.monitoring', ['status' => 'pending'])"
                    :current="Request::is('whatsapp/monitoring/pending')" wire:navigate>Belum Kirim
                </flux:navlist.item>
                <flux:navlist.item icon="arrow-path" :href="route('whatsapp.monitoring', ['status' => 'processing'])"
                    :current="Request::is('whatsapp/monitoring/processing')" wire:navigate>Dalam Antrian
                </flux:navlist.item>
                {{--            <flux:navlist.item icon="chat-bubble-left-ellipsis" :href="route('whatsapp.history')" --}}
                {{--                               :current="request()->routeIs('whatsapp.history')" wire:navigate>Riwayat Pesan --}}
                {{--            </flux:navlist.item> --}}
                {{--            <flux:navlist.item icon="cog-6-tooth" :href="route('whatsapp.setting')" --}}
                {{--                               :current="request()->routeIs('whatsapp.setting')" wire:navigate>Whatsapp --}}
                {{--            </flux:navlist.item> --}}
            </flux:navlist.group>
            <flux:navlist.group class="grid">
                <flux:navlist.item icon="tag" :href="route('limit.daily')"
                    :current="request()->routeIs('limit.daily')" wire:navigate>Limit Jajan
                </flux:navlist.item>
                <flux:navlist.item icon="credit-card" :href="route('pengaturan.account-bank')"
                    :current="request()->routeIs('pengaturan.account-bank')" wire:navigate>Account Bank
                </flux:navlist.item>
                <flux:navlist.item icon="adjustments-horizontal" :href="route('pengaturan.jenis-transaksi')"
                    :current="request()->routeIs('pengaturan.jenis-transaksi')" wire:navigate>Jenis transaksi
                </flux:navlist.item>
                <flux:navlist.item icon="inbox-stack" :href="route('backup')" :current="request()->routeIs('backup')"
                    wire:navigate>Backup
                </flux:navlist.item>
            </flux:navlist.group>
    </flux:navlist>

    <!-- Desktop User Menu -->
</flux:sidebar>
