<script type="text/template" data-grid="standard" data-template="results">

    <% _.each(results, function(r) { %>

        <tr>
            <td><%= r.id %></td>
            <td><%= r.name %></td>
            <td><%= r.supplier %></td>
            <td><%= r.irc_active %></td>
            <td><%= r.mir_active %></td>
            <td><%= r.created_at %></td>
            <td><%= r.updated_at %></td>
            <td><a href="/admin/brands/<%= r.id %>/edit" class="btn blue" role="button"><i class="fa fa-pencil"></i> Edit Brand </a></td>
        </tr>

    <% }); %>

</script>