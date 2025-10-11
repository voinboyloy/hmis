<table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">Service/Medication</th>
            <th scope="col" class="px-6 py-3">Quantity</th>
            <th scope="col" class="px-6 py-3">Unit Price</th>
            <th scope="col" class="px-6 py-3">Total</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($items as $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <td class="px-6 py-4">{{ $item->service ? $item->service->name : ($item->medication ? $item->medication->name : 'N/A') }}</td>
                <td class="px-6 py-4">{{ $item->quantity }}</td>
                <td class="px-6 py-4">${{ number_format($item->unit_price, 2) }}</td>
                <td class="px-6 py-4">${{ number_format($item->quantity * $item->unit_price, 2) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="px-6 py-4 text-center">No items for this invoice.</td>
            </tr>
        @endforelse
    </tbody>
</table>