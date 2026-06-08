import './bootstrap';

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

function showFlash(message, type = 'success') {
    const flashSlot = document.querySelector('[data-flash-slot]');

    if (!flashSlot) {
        return;
    }

    flashSlot.innerHTML = `
        <div class="rounded-2xl border px-4 py-3 text-sm ${type === 'error' ? 'border-rose-400/20 bg-rose-400/10 text-rose-100' : 'border-emerald-400/20 bg-emerald-400/10 text-emerald-100'}">
            ${message}
        </div>
    `;
}

async function sendTaskRequest(url, method) {
    const response = await fetch(url, {
        method,
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
    });

    if (!response.ok) {
        const payload = await response.json().catch(() => null);
        const message = payload?.message ?? 'something went wrong';
        throw new Error(message);
    }

    return response.json().catch(() => ({}));
}

document.addEventListener('click', async (event) => {
    const toggleButton = event.target.closest('[data-task-toggle]');
    const deleteButton = event.target.closest('[data-task-delete]');

    if (toggleButton) {
        try {
            const taskId = toggleButton.dataset.taskId;
            const payload = await sendTaskRequest(toggleButton.dataset.url, 'PATCH');
            const task = payload.task;
            const card = document.getElementById(`task-${taskId}`);
            const badge = document.querySelector(`[data-task-status="${taskId}"]`);

            if (badge && task) {
                badge.textContent = task.completed ? 'completed' : 'pending';
                badge.className = `rounded-full px-3 py-1 text-xs font-semibold ${task.completed ? 'bg-emerald-400/15 text-emerald-200' : 'bg-amber-400/15 text-amber-200'}`;
            }

            if (card) {
                card.classList.add('ring-2', 'ring-cyan-300/30');
                window.setTimeout(() => card.classList.remove('ring-2', 'ring-cyan-300/30'), 500);
            }

            showFlash(payload.message ?? 'task updated successfully');
        } catch (error) {
            showFlash(error.message, 'error');
        }
    }

    if (deleteButton) {
        try {
            const payload = await sendTaskRequest(deleteButton.dataset.url, 'DELETE');
            const card = document.getElementById(`task-${deleteButton.dataset.taskId}`);

            if (card) {
                card.remove();
            }

            showFlash(payload.message ?? 'task deleted successfully');
        } catch (error) {
            showFlash(error.message, 'error');
        }
    }
});import './bootstrap';
