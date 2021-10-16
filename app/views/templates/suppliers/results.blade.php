<script type="text/template" data-grid="standard" data-template="results">

    <% _.each(results, function(r) { %>

        <tr>
            <td><%= r.id %></td>
            <td><%= r.name %></td>
            <td><%= r.created_at %></td>
            <td><%= r.updated_at %></td>
            <td><a href="/admin/suppliers/<%= r.id %>/edit" class="btn blue" role="button"><i class="fa fa-pencil"></i> Edit Suppliers </a></td>
        </tr>

    <% }); %>

</script>