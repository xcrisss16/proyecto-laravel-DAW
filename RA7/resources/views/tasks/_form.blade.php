@csrf
@if ($task->exists)
    @method('PUT')
@endif

<div class="grid gap-5">
    <div>
        <label for="title" class="mb-2 block text-sm font-semibold text-slate-200">title</label>
        <input id="title" name="title" value="{{ old('title', $task->title) }}" required maxlength="255"
            class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-cyan-300 focus:bg-white/10" placeholder="write a clear task title">
    </div>

    <div>
        <label for="description" class="mb-2 block text-sm font-semibold text-slate-200">description</label>
        <textarea id="description" name="description" rows="6" maxlength="1000"
            class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white outline-none transition placeholder:text-slate-500 focus:border-cyan-300 focus:bg-white/10" placeholder="add the details here">{{ old('description', $task->description) }}</textarea>
    </div>

    <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm text-slate-200">
        <input type="hidden" name="completed" value="0">
        <input type="checkbox" name="completed" value="1" @checked(old('completed', $task->completed)) class="h-5 w-5 rounded border-white/20 bg-white/10 text-cyan-400 focus:ring-cyan-300">
        mark as completed
    </label>

    <div class="flex items-center gap-3">
        <button type="submit" class="rounded-full bg-cyan-400 px-5 py-3 font-semibold text-slate-950 transition hover:bg-cyan-300">{{ $submitLabel }}</button>
        <a href="{{ route('tasks.index') }}" class="rounded-full border border-white/10 px-5 py-3 font-semibold text-slate-200 transition hover:border-white/30 hover:text-white">back</a>
    </div>
</div>