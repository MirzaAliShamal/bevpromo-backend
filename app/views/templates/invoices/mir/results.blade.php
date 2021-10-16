<script type="text/template" data-grid="standard" data-template="results">

    <% _.each(results, function(r) { %>

        <tr>
            <td><a href="/admin/coupons/irc/<%= r.id %>/edit"><%= r.id %></a></td>
            <td><a href="/admin/coupons/irc/<%= r.id %>/edit"><%= r.name %></a></td>
            <td><a href="/admin/coupons/irc/<%= r.id %>/edit"><%= r.coupon_type_id %></a></td>
            <td><a href="/admin/coupons/irc/<%= r.id %>/edit"><%= r.description %></a></td>
            <td><a href="/admin/coupons/irc/<%= r.id %>/edit"><%= r.expires %></a></td>
            <td><a href="/admin/coupons/irc/<%= r.id %>/edit"><%= r.receive_by %></a></td>
            <td><a href="/admin/coupons/irc/<%= r.id %>/edit"><%= r.active %></a></td>
            <td><a href="/admin/coupons/irc/<%= r.id %>/edit"><%= r.owner_id %></a></td>
            <td><a href="/admin/coupons/irc/<%= r.id %>/edit"><%= r.brand_id %></a></td>
            <td><a href="/admin/coupons/irc/<%= r.id %>/edit"><%= r.send_to_id %></a></td>
            <td><a href="/admin/coupons/irc/<%= r.id %>/edit"><%= r.created_at %></a></td>
            <td><a href="/admin/coupons/irc/<%= r.id %>/edit"><%= r.updated_at %></a></td>
        </tr>

    <% }); %>

</script>