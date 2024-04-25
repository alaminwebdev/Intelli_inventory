<!-- Update your product checkboxes with a class (e.g., 'product-checkbox') -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Select Product</th>
            <th style="width:10%;">Remaining</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2">
                <!-- Add a "Select All" checkbox -->
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="selectAll" style="cursor: pointer">
                    <label for="selectAll" class="custom-control-label" style="cursor: pointer">Select All</label>
                </div>
            </td>
        </tr>
        @foreach ($products as $product)
            <tr>
                <td>
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input product-checkbox" type="checkbox" id="selected_products_{{ $product->product_id }}" name="selected_products[]" value="{{ $product->product_id }}" style="cursor: pointer">
                        <label for="selected_products_{{ $product->product_id }}" class="custom-control-label" style="cursor: pointer">{{ $product->product }} ({{ $product->unit }})</label>
                    </div>
                </td>
                <td class="text-right reject-qty">
                    {{ $product->reject_qty }}
                </td>
            </tr>
        @endforeach

    </tbody>
</table>


<script>
    $(document).ready(function() {
        // Add an event listener to the "Select All" checkbox
        $('#selectAll').on('change', function() {
            // Get all product checkboxes
            const productCheckboxes = document.querySelectorAll('.product-checkbox');

            // Set their checked status to match the "Select All" checkbox
            productCheckboxes.forEach(function(checkbox) {
                // Check if the product has a non-zero reject quantity before setting the checkbox status
                const productRow = checkbox.closest('tr');
                const rejectQtyCell = productRow.querySelector('.reject-qty');
                const rejectQty = parseInt(rejectQtyCell.textContent);

                // Only set the checkbox as checked if the reject quantity is greater than 0
                checkbox.checked = ($('#selectAll').prop('checked') && rejectQty > 0);
            });
        });

        // Add an event listener to individual product checkboxes
        $('.product-checkbox').on('change', function() {
            // Get the reject quantity of the product associated with this checkbox
            const productRow = this.closest('tr');
            const rejectQtyCell = productRow.querySelector('.reject-qty');
            const rejectQty = parseInt(rejectQtyCell.textContent);

            // Prevent the checkbox from being checked if reject quantity is 0
            if (rejectQty === 0) {
                this.checked = false;
            }
        });

        // ...
    });
</script>
