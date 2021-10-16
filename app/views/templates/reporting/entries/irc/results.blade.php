<script type="text/template" data-grid="standard" data-template="results">

    <% _.each(results, function(r) { %>

        <tr>
            <td><%= r.id %></td>
            <td><%= r.retailer %></td>
            <td><%= r.retailer_state %></td>
            <td><%= r.program %></td>
            <td><%= r.clearinghouse %></td>
            <td><%= r.is_invoiced %></td>
            <td><%= r.coupon_quantity %></td>
            <td><%= r.created_at %></td>
        </tr>

    <% }); %>

</script>