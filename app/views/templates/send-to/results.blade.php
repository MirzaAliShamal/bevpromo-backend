<script type="text/template" data-grid="standard" data-template="results">

    <% _.each(results, function(r) { %>

        <tr>
            <td><%= r.id %></td>
            <td><%= r.name %></td>
            <td><%= r.address %></td>
            <td><%= r.city %></td>
            <td><%= r.state %></td>
            <td><%= r.zip %></td>
            <td><%= r.clearinghouse %></td>
            <td><%= r.created_at %></td>
            <td><%= r.updated_at %></td>
            <td><a href="/admin/send-to/<%= r.id %>/edit" class="btn blue" role="button"><i class="fa fa-pencil"></i> Edit Send-To </a></td>
        </tr>

    <% }); %>

</script>