@props(['lead' => null])

<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <input name="name" value="{{ old('name', $lead->name ?? '') }}" class="mt-1 block w-full border rounded px-3 py-2" />
        @error('name')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input name="email" value="{{ old('email', $lead->email ?? '') }}" class="mt-1 block w-full border rounded px-3 py-2" />
        @error('email')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Phone</label>
        <input name="phone" value="{{ old('phone', $lead->phone ?? '') }}" class="mt-1 block w-full border rounded px-3 py-2" />
        @error('phone')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Status</label>
        <select name="status" class="mt-1 block w-full border rounded px-3 py-2">
            @foreach(['new' => 'New', 'in_progress' => 'In Progress', 'closed' => 'Closed'] as $val => $label)
                <option value="{{ $val }}" {{ old('status', $lead->status ?? '') === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        @error('status')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>
