<script type="text/template" data-grid="standard" data-template="results">

    <% _.each(results, function(r) { %>

        <tr>
            <td><%= r.id %></td>
            <td><%= r.name %></td>
            <% if (r.active === 0) {  %>
                <td>No</td>
            <% } else { %>
                <td>Yes</td>
            <% } %>
            
            <td><a href="/admin/edit/denial/reasons/<%= r.id %>" class="btn blue" role="button"><i class="fa fa-pencil"></i> Edit </a></td>
        </tr>

    <% }); %>

</script>