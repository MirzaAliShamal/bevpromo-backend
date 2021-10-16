<script type="text/template" data-grid="standard" data-template="results">

    <% _.each(results, function(r) { %>

        <tr>
            <td><%= r.f_month %></td>
            <td><%= r.retailer %></td>
            <td><%= r.total %></td>
        </tr>

    <% }); %>

</script>