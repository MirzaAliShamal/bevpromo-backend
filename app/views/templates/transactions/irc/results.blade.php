<script type="text/template" data-grid="standard" data-template="results">

    <% _.each(results, function(r) { %>

        <tr>
            <td><%= r.id %></td>
            <td><%= r.type %></td>
            <td><%= r.amount %></td>
            <td><%= r.created_at %></td>
            <td><%= r.updated_at %></td>
            <td><a href="/admin/invoices/irc/<%= r.id %>"  class="btn blue" role="button">View  <i class="fa fa-file-text"></i></a></td>
            <td><a href="/admin/invoices/irc/<%= r.id %>/edit"  class="btn green" role="button">Edit  <i class="fa fa-pencil"></i></a></td>

        </tr>

    <% }); %>

</script>