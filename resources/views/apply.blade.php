<form method="POST" action="{{ route('apply.store') }}">
    @csrf <!-- Wichtiger Schutz von Laravel -->

    <!-- Name des Anwärters -->
    <div>
        <label for="name">Dein Name</label>
        <input id="name" type="text" name="name" required autofocus>
        @error('name') <span>{{ $message }}</span> @enderror
    </div>

    <!-- E-Mail -->
    <div>
        <label for="email">Deine E-Mail</label>
        <input id="email" type="email" name="email" required>
        @error('email') <span>{{ $message }}</span> @enderror
    </div>

    <!-- Passwort -->
    <div>
        <label for="password">Passwort</label>
        <input id="password" type="password" name="password" required>
        @error('password') <span>{{ $message }}</span> @enderror
    </div>

    <!-- Passwort Bestätigung -->
    <div>
        <label for="password_confirmation">Passwort bestätigen</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required>
    </div>

    <!-- Gewünschter Familienname -->
    <div>
        <label for="family_name">Gewünschter Name der Familie</label>
        <input id="family_name" type="text" name="family_name" required>
        @error('family_name') <span>{{ $message }}</span> @enderror
    </div>

    <button type="submit">Antrag stellen</button>
</form>
