<script type="text/template" data-grid="standard" data-template="results">

    <% _.each(results, function(r) { %>
        <tr>
            <td><%= r.id %></td>
            <td><%= r.default_field_name %></td>
            <td><%=  r.default_field_data %></td>
            
            <td><a href="/admin/coupons/default-text/<%= r.id %>/edit" class="btn blue" role="button"><i class="fa fa-pencil"></i> Edit Field </a></td>
        </tr>

    <% }); %>

</script>