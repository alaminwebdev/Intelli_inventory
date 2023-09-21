<table class="table border table-bordered">
    <thead>
        <tr>
            <th style="width:4%;text-align:center;">বাছাই</th>
            <th>পন্য</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($product_types as $product_type)
            <tr class="group-header collapsed " data-toggle="collapse" data-target="#{{ 'group_' . $product_type['id'] }}" style="cursor: pointer; background: #f8f9fa;">
                <td class="text-center">
                    <span class="expand-icon badge badge-success" style="transition: all .2s linear"><i class="fas fa-plus" style="transition: all .2s linear"></i></span>
                </td>
                <td>
                    <strong class="text-gray">{{ $product_type['name'] }}</strong>
                </td>
            </tr>
            <tr id="{{ 'group_' . $product_type['id'] }}" class="collapse">
                <td colspan="2" class="p-2">
                    <table class="table table-bordered sub-table">
                        <tbody>
                            @foreach ($product_type['products'] as $product)
                                <tr>
                                    <td class="text-center" style="width:5%;">
                                        <div class="custom-control custom-checkbox" style="padding-left: 2rem;">
                                            <input class="custom-control-input" type="checkbox" id="selected_products_{{ $product['id'] }}" name="selected_products[]" value="{{ $product['id'] }}" style="cursor: pointer">
                                            <label for="selected_products_{{ $product['id'] }}" class="custom-control-label" style="cursor: pointer"></label>
                                        </div>
                                    </td>
                                    <td>{{ $product['name'] }}({{ $product['unit'] }})</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $(".group-header").on("click", function() {
            var span = $(this).find(".expand-icon");
            var icon = span.find("i");

            if ($(this).hasClass("collapsed")) {
                icon.removeClass("fa-plus").addClass("fa-minus");
                span.removeClass("badge-success").addClass("badge-danger");
            } else {
                icon.removeClass("fa-minus").addClass("fa-plus");
                span.removeClass("badge-danger").addClass("badge-success");
            }
        });
    });
</script>
