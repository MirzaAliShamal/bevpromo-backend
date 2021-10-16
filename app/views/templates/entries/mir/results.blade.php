<script type="text/template" data-grid="standard" data-template="results">

    <% _.each(results, function(r) { %>

        <tr>
            <td><%= r.id %></td>
            <td><%= r.retailer %></td>
            <td><%= r.coupon %></td>
            <td><%= r.owner %></td>
            <td><%= r.first_name %></td>
            <td><%= r.last_name %></td>
            <td><%= r.address %></td>
            <td><%= r.city %></td>
            <td><%= r.state %></td>
            <td><%= r.zip %></td>
            <td><%= r.status %></td>
            <td><%= r.created_at %></td>
            <td><%= r.program_type %></td>
            <td><a href="/admin/entries/mir/<%= r.id %>/edit" class="btn blue" role="button"><i class="fa fa-pencil"></i> Edit Entry </a></td>
        </tr>

    <% }); %>

</script>