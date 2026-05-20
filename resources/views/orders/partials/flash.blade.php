@if(session('status'))
    <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-4 text-green-700 dark:border-green-900 dark:bg-green-950 dark:text-green-300">
        {{ session('status') }}
    </div>
@endif

