    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
        <div class="flex justify-between items-end">
                <!-- Billing Details -->
                <div class="text-xs">
                    <h3 class="text-gray-600 dark:text-gray-400 font-medium tracking-tight mb-1">BILL TO</h3>
                    <p class="text-base font-bold">John Doe</p>
                    <p>123 Main Street</p>
                    <p>New York, New York 10001</p>
                    <p>United States</p>
                </div>

                <div class="text-xs">
                    <table class="min-w-full">
                        <tbody>
                        <tr>
                            <td class="font-semibold text-right pr-2">Invoice Number:</td>
                            <td class="text-left pl-2">123</td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-right pr-2">Invoice Date:</td>
                        </tr>
                        <tr>
                            <td class="font-semibold text-right pr-2">Payment Due:</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
