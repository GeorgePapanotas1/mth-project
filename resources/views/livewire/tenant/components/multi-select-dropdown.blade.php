<div class="w-full mx-auto">
    <label for="multi-select" class="block text-sm font-medium text-gray-700">Select Options</label>
    <select id="multi-select" wire:model="selectedOptions" multiple class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
        @foreach ($options as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </select>

    <!-- Displaying Selected Options -->
    <div class="mt-4">
        <strong>Selected:</strong>
        <ul>
            @foreach($selectedOptions as $selected)
                <li>{{ $options[$selected] ?? 'Invalid option' }}</li>
            @endforeach
        </ul>
    </div>
</div>
