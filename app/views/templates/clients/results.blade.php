<script type="text/template" data-grid="standard" data-template="results">

    <% _.each(results, function(r) { %>

        <tr>
            <td><%= r.id %></td>
            <td><%= r.first_name %></td>
            <td><%= r.last_name %></td>
            <td><%= r.email %></td>
            <td><%= r.active %></td>
            <td><%= r.created_at %></td>
            <td><%= r.updated_at %></td>
            <td><a href="/admin/clients/<%= r.id %>/edit" class="btn blue" role="button"><i class="fa fa-pencil"></i> Edit Client </a></td>
        </tr>

    <% }); %>

</script>