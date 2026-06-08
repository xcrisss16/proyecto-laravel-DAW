@if ($errors->any())
    <div class="mb-6 rounded-2xl border border-rose-400/20 bg-rose-400/10 p-4 text-rose-100">
        <p class="mb-2 font-semibold">check the form errors</p>
        <ul class="space-y-1 text-sm">
            @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif