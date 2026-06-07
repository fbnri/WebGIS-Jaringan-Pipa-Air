<x-app-layout>
    <h1>Kelola Admin</h1>

    @foreach($admins as $admin)
        <p>
            {{ $admin->name }}
            ({{ $admin->email }})
            Status:
            {{ $admin->is_active ? 'Aktif' : 'Nonaktif' }}
        </p>
        <form method="POST" action="{{ route('super.users.toggle',$admin->id) }}">
            @csrf
            @method('PATCH')
            <button>
                Toggle Status
            </button>
        </form>
        <form method="POST" action="{{ route('super.users.reset',$admin->id) }}">
            @csrf
            @method('PATCH')
            <button>
                Reset Password
            </button>
        </form>
        <hr>
    @endforeach
</x-app-layout>