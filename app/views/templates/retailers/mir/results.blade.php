<script type="text/template" data-grid="standard" data-template="results">

    <% _.each(results, function(r) { %>

        <tr>
            <td><%= r.id %></td>
            <td><%= r.name %></td>
            <td><%= r.is_active %></td>
            <td><%= r.created_at %></td>
            <td><%= r.updated_at %></td>
            <td><a href="/admin/retailers/mir/<%= r.id %>/edit" class="btn blue" role="button"><i class="fa fa-pencil"></i> Edit Retailer </a></td>
        </tr>

    <% }); %>

</script>