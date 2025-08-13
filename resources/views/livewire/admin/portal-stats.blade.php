<div class="bg-white p-6 rounded-lg shadow-md space-y-4">
    <h3 class="font-bold text-lg">Portal-Statistiken</h3>
    <div class="border-t pt-4">
        <h4 class="font-semibold mb-2">Gerade online ({{ $onlineUsers->count() }})</h4>
        <ul class="text-sm text-gray-600 space-y-1">
            @forelse($onlineUsers as $user)
                <li>{{ $user->name }}</li>
            @empty
                <li>Niemand online.</li>
            @endforelse
        </ul>
    </div>
    <ul>
        <li class="flex justify-between"><span>Benutzer gesamt:</span> <strong>{{ $totalUsers }}</strong></li>
        <li class="flex justify-between"><span>Familien gesamt:</span> <strong>{{ $totalFamilies }}</strong></li>
        <li class="flex justify-between"><span>Fotos gesamt:</span> <strong>{{ $totalPhotos }}</strong></li>
    </ul>
</div>