<!DOCTYPE html>
<html>
<head>
    <title>Admin - Anträge freischalten</title>
</head>
<body>
    <h1>Ausstehende Anträge für Familienoberhäupter</h1>

    <!-- Zeigt Erfolgsmeldungen an -->
    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>E-Mail</th>
                <th>Antragsdatum</th>
                <th>Aktion</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.approvals.approve', $user) }}">
                            @csrf <!-- Wichtiger Schutz -->
                            <button type="submit">Freischalten</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Keine ausstehenden Anträge gefunden.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <br>
    <a href="{{ route('dashboard') }}">Zurück zum Dashboard</a>
</body>
</html>
